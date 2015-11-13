<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\ModelEvent;
use common\models\Person;

/**
 * User model
 *
 * @property integer $id
 * @property integer $id_profile
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $new_email_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $accept_agreement
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class UserFrontend extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_CONFIRM_NEED = 1;
    const STATUS_ACTIVE = 10;

    const EVENT_NEW_USER = 'newUser';
    const EVENT_EMAIL_CHANGED = 'emailChanged';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_frontend}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_CONFIRM_NEED]],

        ];
    }

    /**
     * Get Person.
     * @return Person
     */

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'id_profile']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }


    /**
     * Finds user by new email reset token
     *
     * @param string $token new email token
     * @return static|null
     */
    public static function findByNewEmailToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'new_email_token' => $token,
            'status' => self::STATUS_CONFIRM_NEED,
        ]);
    }

    /**
     * Finds out if new email token is valid
     *
     * @param string $token new email token
     * @return boolean
     */
    public static function isNewEmailTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generateNewEmailToken()
    {
        $this->new_email_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removeNewEmailToken()
    {
        $this->new_email_token = null;
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Generate event EVENT_EMAIL_CHANGED from event afterSave
     * @param boolean $insert whether this method called while inserting a record.
     * @param array $changedAttributes The old values of attributes that had changed and were saved.
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (!empty($changedAttributes['email']))
        {
            $this->trigger(self::EVENT_EMAIL_CHANGED);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function init()
    {
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'sendEmailConfirm']);
        $this->on(self::EVENT_EMAIL_CHANGED, [$this, 'sendEmailConfirm']);
    }

    public function sendEmailConfirm($event)
    {
        $user = $event->sender;
        $user->generateNewEmailToken();
        $user->save();
        $email = \Yii::$app->mailer->compose(['html' => 'emailResetToken-html', 'text' => 'emailResetToken-text'], ['user' => $user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Подтверждение email адреса в базе Абитуриент Марийского радиомеханического техникума')
            ->send();

        if($email){
            Yii::$app->getSession()->setFlash('success','Дальнейшие инструкции отправлены на электронную почту '.$this->email);
        }
        else{
            Yii::$app->getSession()->setFlash('warning','Failed, contact admin!');
        }

    }

}

<?php
namespace frontend\models;

use frontend\models\UserFrontend;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class UserSettingsForm extends Model
{
    private $id;
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'string', 'max' => 255],

/*            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'myCustomUnique'],
//            ['email', 'unique', 'targetClass' => '\frontend\models\UserFrontend', 'message' => 'This email address has already been taken.'],
*/

//            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function myCustomUnique($attribute)
    {

        $user = UserFrontend::find()
            ->where(['!=', 'id', $this->id])
            ->andWhere(['=', $attribute, $this[$attribute]])
            ->one();
        if (!empty($user))
            $this->addError($attribute, 'This attribute already been taken.');
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'E-mail',
            'password' => 'Пароль',
        ];
    }

    public function init()
    {
        $id = Yii::$app->getUser()->getId();
        $this->id = $id;
        $this->attributes = UserFrontend::findIdentity($id)->attributes;

    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function update()
    {
        $id = Yii::$app->getUser()->getId();
        $user = UserFrontend::findIdentity($id);

        if ($this->validate() and isset($user)) {
            $user->username = $this->username;
            if (!empty($this->password))
                $user->setPassword($this->password);
            if ($user->save()) {
                return $user;
            }
            else {
                Yii::$app->getSession()->setFlash('error','not save user settings');
            }
        }

        return null;
    }
}

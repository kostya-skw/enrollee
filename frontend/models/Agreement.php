<?php
/**
 * Created by PhpStorm.
 * User: kostys
 * Date: 06.10.15
 * Time: 10:24
 */
namespace frontend\models;

use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Agreement extends Model
{
    public $consent_processing_personal_data;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['consent_processing_personal_data', 'integer', 'min' => 0, 'max' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'consent_processing_personal_data' => 'Согласен на обработку персональных данных',
        ];
    }

    public function attributeHints()
    {
        return [
            'consent_processing_personal_data' => 'Я даю свое согласие на обработку персональных данных',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function AcceptConsentProcessingPersonalData()
    {
        $id = Yii::$app->getUser()->getId();
        $user = UserFrontend::findIdentity($id);

        if ($this->validate()and(!empty($user))) {
            $user->consent_processing_personal_data = 1;
            if ($user->save()) {
                return $user;
            }
            else {
                Yii::$app->getSession()->setFlash('error','Error accept agreement');
            }
        }

        return null;
    }
}

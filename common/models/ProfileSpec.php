<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile_spec".
 *
 * @property integer $id
 * @property integer $id_profile
 * @property integer $id_spec
 * @property integer $form_fulltime
 * @property integer $form_extramural
 * @property integer $priority
 */
class ProfileSpec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_profile', 'id_spec', 'form_fulltime', 'form_extramural', 'priority'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('spec', 'ID'),
            'id_profile' => Yii::t('spec', 'Id Profile'),
            'id_spec' => Yii::t('spec', 'Id Spec'),
            'form_fulltime' => Yii::t('spec', 'Fulltime'),
            'form_extramural' => Yii::t('spec', 'Extramural'),
            'priority' => Yii::t('spec', 'Priority'),
        ];
    }

    /**
     * Get Spec.
     * @return Spec
     */

    public function getSpec()
    {
        return $this->hasOne(Spec::className(), ['id'=>'id_spec']);
    }

}

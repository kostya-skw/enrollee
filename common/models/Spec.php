<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "spec".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer form_fulltime
 * @property integer form_extramural
 * @property integer base_9
 * @property integer base_11
 */
class Spec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'name'], 'trim'],
            [['code'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 255],
            ['form_fulltime', 'integer', 'min' => 0, 'max' => 1],
            ['form_extramural', 'integer', 'min' => 0, 'max' => 1],
            ['base_9', 'integer', 'min' => 0, 'max' => 1],
            ['base_11', 'integer', 'min' => 0, 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('spec', 'ID'),
            'code' => Yii::t('spec', 'Code'),
            'name' => Yii::t('spec', 'Name'),
            'form_fulltime' => Yii::t('spec', 'Fulltime'),
            'form_extramural' => Yii::t('spec', 'Extramural'),
            'base_9' => Yii::t('spec', 'Base 9'),
            'base_11' => Yii::t('spec', 'Base 11'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->form_fulltime = 1;
        $this->form_extramural = 0;
        $this->base_9 = 1;
        $this->base_11 = 1;
    }
}

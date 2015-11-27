<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $id_person
 * @property integer $edu_second_prof
 * @property integer $edu_base
 * @property string $edu_level
 * @property string $edu_institution
 * @property integer $edu_year_end
 * @property string $edu_document_type
 * @property string $edu_document_sequence
 * @property string $edu_document_number
 * @property integer $edu_medal
 * @property integer $edu_winner
 * @property string $insurance_certificate
 * @property string $military_certificate_number
 * @property string $military_certificate_where
 * @property string $military_card_number
 * @property integer $lang_eng
 * @property integer $lang_de
 * @property integer $lang_fr
 * @property string $lang_other
 * @property integer $hostel
 * @property integer $facility
 * @property string $facility_name
 * @property string $facility_document
 * @property string $additional_information
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Profile extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = -1;
    const STATUS_NEW = 0;
    const STATUS_REVIEW = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_person', 'edu_second_prof', 'edu_base', 'edu_year_end', 'edu_medal', 'edu_winner', 'lang_eng', 'lang_de', 'lang_fr', 'hostel', 'facility'], 'integer'],
            [['edu_base', 'edu_level', 'edu_institution', 'edu_year_end', 'edu_document_type', 'edu_document_sequence', 'edu_document_number'], 'required'],
            [['additional_information'], 'string'],
            [['edu_level'], 'string', 'max' => 3],
            [['edu_institution', 'military_certificate_where', 'lang_other', 'facility_name', 'facility_document'], 'string', 'max' => 255],
            [['edu_document_type'], 'string', 'max' => 8],
            [['edu_document_sequence', 'military_certificate_number', 'military_card_number'], 'string', 'max' => 15],
            [['edu_document_number'], 'string', 'max' => 30],
            [['insurance_certificate'], 'string', 'max' => 14]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('profile', 'ID'),
            'id_person' => Yii::t('profile', 'Id Person'),
            'edu_second_prof' => Yii::t('profile', 'Edu Second Prof'),
            'edu_base' => Yii::t('profile', 'Edu Base'),
            'edu_level' => Yii::t('profile', 'Edu Level'),
            'edu_institution' => Yii::t('profile', 'Edu Institution'),
            'edu_year_end' => Yii::t('profile', 'Edu Year End'),
            'edu_document_type' => Yii::t('profile', 'Edu Document Type'),
            'edu_document_sequence' => Yii::t('profile', 'Edu Document Sequence'),
            'edu_document_number' => Yii::t('profile', 'Edu Document Number'),
            'edu_medal' => Yii::t('profile', 'Edu Medal'),
            'edu_winner' => Yii::t('profile', 'Edu Winner'),
            'insurance_certificate' => Yii::t('profile', 'Insurance Certificate'),
            'military_certificate_number' => Yii::t('profile', 'Military Certificate Number'),
            'military_certificate_where' => Yii::t('profile', 'Military Certificate Where'),
            'military_card_number' => Yii::t('profile', 'Military Card Number'),
            'lang_eng' => Yii::t('profile', 'Lang Eng'),
            'lang_de' => Yii::t('profile', 'Lang De'),
            'lang_fr' => Yii::t('profile', 'Lang Fr'),
            'lang_other' => Yii::t('profile', 'Lang Other'),
            'hostel' => Yii::t('profile', 'Hostel'),
            'facility' => Yii::t('profile', 'Facility'),
            'facility_name' => Yii::t('profile', 'Facility Name'),
            'facility_document' => Yii::t('profile', 'Facility Document'),
            'additional_information' => Yii::t('profile', 'Additional Information'),
            'status' => Yii::t('profile', 'Status'),
            'statusAsText' => Yii::t('profile', 'Status'),
            'created_at' => Yii::t('profile', 'Created At'),
            'updated_at' => Yii::t('profile', 'Updated At'),
        ];
    }

    public function behaviors()
     {
         return [
             'timestamp' => [
                 'class' => 'yii\behaviors\TimestampBehavior',
                 'attributes' => [
                     ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                     ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                 ],
             ],
         ];
     }

    /**
     * Get Person.
     * @return Person
     */

    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'id_person']);
    }

    /**
     * Get Specs.
     * @return Specs
     */

    public function getSpecs()
    {
        return $this->hasMany(ProfileSpec::className(), ['id_profile'=>'id']);
    }

    /**
     * Get All specs with choice.
     * @return Specs
     */

    public function getSpecsAllWithChoice($base = null)
    {
        $query = new Query;
        // compose the query
        $query->select('
                t1.id AS id,
                t1.code AS code,
                t1.name AS name,
                t1.form_fulltime AS form_fulltime,
                t1.form_extramural AS form_extramural,
                t1.base_9 AS base_9,
                t1.base_11 AS base_11,
                t2.form_fulltime AS ch_ff,
                t2.form_extramural AS ch_fe
            ')
            ->from('spec t1')
            ->join('LEFT JOIN', 'profile_spec t2', 't2.id_spec=t1.id')
            ->orderBy('CAST(t2.priority as unsigned) DESC, t2.priority')
            ->limit(20);

        if ($base == 9)
            $query->andWhere('t1.base_9=1');
        if ($base == 11)
            $query->andWhere('t1.base_11=1');

        // build and execute the query
        return $query->createCommand()->queryAll();

    }

/*    public function getSpecs()
    {
        return $this->hasMany(Spec::className(), ['id'=>'id_spec'])
            ->viaTable('app_spec', ['id_profle'=>'id']);
    }*/

    /**
     * @inheritdoc
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findByIdPerson($id)
    {
        return static::findOne(['id_person' => $id]);
    }

    /**
     * Get StatusAsText.
     * @return Person
     */

    public function getStatusAsText()
    {
        switch ($this->status) {
            case $this::STATUS_NEW:
                return 'Новый';
                break;
            case $this::STATUS_REVIEW;
                return 'Готов к рассмотрению';
                break;
        };
    }

    public function loadModel($id)
    {
        $profile = Profile::findById($id);
        if(!empty($profile)) {
            $this->id = $profile->id;
            $this->status= $profile->status;
            $this->created_at= $profile->created_at;
            $this->updated_at= $profile->updated_at;
            $this->attributes = $profile->attributes;
            return true;
        } else {
            return false;
        }

    }

}

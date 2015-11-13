<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property string $parent1_type
 * @property integer $id_parent1
 * @property string $parent2_type
 * @property integer $id_parent2
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $date_of_birth
 * @property string $birthplace
 * @property string $nationality
 * @property string $identity_type
 * @property string $identity_sequence
 * @property string $identity_number
 * @property string $identity_date_issue
 * @property string $identity_who_issue
 * @property string $identity_who_issue_number
 * @property string $address_registration_postcode
 * @property string $address_registration_country
 * @property string $address_registration_subject
 * @property string $address_registration_region
 * @property string $address_registration_point
 * @property integer $address_real_idem
 * @property string $address_real_postcode
 * @property string $address_real_country
 * @property string $address_real_subject
 * @property string $address_real_region
 * @property string $address_real_point
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $job_where
 * @property string $job_who
 * @property integer $job_seniority
 * @property integer $created_at
 * @property integer $updated_at
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_real_idem', 'job_seniority', 'created_at', 'updated_at'], 'integer'],
            [['surname', 'name', 'patronymic'], 'required'],
            [['date_of_birth', 'identity_date_issue'], 'safe'],
            [['surname', 'name', 'patronymic', 'birthplace', 'nationality', 'identity_who_issue', 'contact_phone', 'contact_email', 'job_where', 'job_who'], 'string', 'max' => 255],
            [['parent1_type', 'parent2_type', 'identity_type'], 'string', 'max' => 50],
            [['identity_sequence'], 'string', 'max' => 15],
            [['identity_number'], 'string', 'max' => 30],
            [['identity_who_issue_number'], 'string', 'max' => 7],
            [['address_registration_postcode', 'address_real_postcode'], 'string', 'max' => 6],
            [['address_registration_country', 'address_registration_subject', 'address_registration_region', 'address_registration_point', 'address_registration', 'address_real_country', 'address_real_subject', 'address_real_region', 'address_real_point', 'address_real'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('person', 'ID'),
            'id_parent1' => Yii::t('person', 'Id Father Person'),
            'id_parent2' => Yii::t('person', 'Id Mather Person'),
            'surname' => Yii::t('person', 'Surname'),
            'name' => Yii::t('person', 'Name'),
            'patronymic' => Yii::t('person', 'Patronymic'),
            'date_of_birth' => Yii::t('person', 'Date Of Birth'),
            'birthplace' => Yii::t('person', 'Birthplace'),
            'nationality' => Yii::t('person', 'Nationality'),
            'identity_type' => Yii::t('person', 'Identity Type'),
            'identity_sequence' => Yii::t('person', 'Identity Sequence'),
            'identity_number' => Yii::t('person', 'Identity Number'),
            'identity_date_issue' => Yii::t('person', 'Identity Date Issue'),
            'identity_who_issue' => Yii::t('person', 'Identity Who Issue'),
            'identity_who_issue_number' => Yii::t('person', 'Identity Who Issue Number'),
            'address_registration_postcode' => Yii::t('person', 'Address Registration Postcode'),
            'address_registration_country' => Yii::t('person', 'Address Registration Country'),
            'address_registration_subject' => Yii::t('person', 'Address Registration Subject'),
            'address_registration_region' => Yii::t('person', 'Address Registration Region'),
            'address_registration_point' => Yii::t('person', 'Address Registration Point'),
            'address_real_idem' => Yii::t('person', 'Address Real Idem'),
            'address_real_postcode' => Yii::t('person', 'Address Real Postcode'),
            'address_real_country' => Yii::t('person', 'Address Real Country'),
            'address_real_subject' => Yii::t('person', 'Address Real Subject'),
            'address_real_region' => Yii::t('person', 'Address Real Region'),
            'address_real_point' => Yii::t('person', 'Address Real Point'),
            'contact_phone' => Yii::t('person', 'Contact Phone'),
            'contact_email' => Yii::t('person', 'Contact Email'),
            'job_where' => Yii::t('person', 'Job Where'),
            'job_who' => Yii::t('person', 'Job Who'),
            'job_seniority' => Yii::t('person', 'Job Seniority'),
            'created_at' => Yii::t('person', 'Created At'),
            'updated_at' => Yii::t('person', 'Updated At'),
            'namefull' => Yii::t('person', 'Name'),
            'addressfull' => Yii::t('person', 'Address'),
            'identityfull' => Yii::t('person', 'Identity'),
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
     * Get Father.
     * @return Person|Null
     */

    public function getParent1()
    {
        return $this->hasOne(Person::className(), ['id' => 'id_parent1']);
    }

    /**
     * Get Mather.
     * @return Person|Null
     */

    public function getParent2()
    {
        return $this->hasOne(Person::className(), ['id' => 'id_parent2']);
    }

    /**
     * Get enrollee application.
     * @return Profile
     */

    public function getApplication()
    {
        return $this->hasOne(Profile::className(), ['id_person' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Get Name full.
     * @return string
     */

    public function getNameFull()
    {
        return "{$this->surname} {$this->name} {$this->patronymic}";
    }

    /**
     * Get address full.
     * @return string
     */

    public function getAddressFull()
    {
        $address = array_diff([
            $this->address_registration_postcode,
            $this->address_registration_country,
            $this->address_registration_subject,
            $this->address_registration_region,
            $this->address_registration_point,
            $this->address_registration
        ], array(''));

        return implode(', ', $address);
    }

    /**
     * Get address full.
     * @return string
     */

    public function getIdentityFull()
    {
        $identity = array_diff([
            $this->identity_type,
            $this->identity_sequence,
            $this->identity_number,
            $this->identity_date_issue,
            $this->identity_who_issue,
            $this->identity_who_issue_number
        ], array(''));

        return implode(', ', $identity);
    }
}

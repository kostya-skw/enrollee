<?php
/**
 * Created by PhpStorm.
 * User: kostys
 * Date: 29.09.15
 * Time: 13:50
 */

namespace common\models;

use Yii;
use yii\base\Model;
use ReflectionClass;
use common\models\Person;
use common\models\Profile;
use frontend\models\UserFrontend;

/**
 * Abitur Application form
 */
class ProfileForm extends Model
{
    public $id;

    public $id_person;
    public $parent1_type;
    public $id_parent1;
    public $parent2_type;
    public $id_parent2;

    public $surname;
    public $name;
    public $patronymic;
    public $date_of_birth;
    public $birthplace;
    public $nationality;
    public $identity_type;
    public $identity_sequence;
    public $identity_number;
    public $identity_date_issue;
    public $identity_who_issue;
    public $identity_who_issue_number;
    public $address_registration_postcode;
    public $address_registration_country;
    public $address_registration_subject;
    public $address_registration_region;
    public $address_registration_point;
    public $address_registration;
    public $address_real_idem;
    public $address_real_postcode;
    public $address_real_country;
    public $address_real_subject;
    public $address_real_region;
    public $address_real_point;
    public $address_real;
    public $contact_phone;
    public $contact_email;
    public $job_where;
    public $job_who;
    public $job_seniority;
    public $it_payer;

    public $parent1_surname;
    public $parent1_name;
    public $parent1_patronymic;
    public $parent1_date_of_birth;
    public $parent1_birthplace;
    public $parent1_nationality;
    public $parent1_identity_type;
    public $parent1_identity_sequence;
    public $parent1_identity_number;
    public $parent1_identity_date_issue;
    public $parent1_identity_who_issue;
    public $parent1_identity_who_issue_number;
    public $parent1_address_registration_postcode;
    public $parent1_address_registration_country;
    public $parent1_address_registration_subject;
    public $parent1_address_registration_region;
    public $parent1_address_registration_point;
    public $parent1_address_registration;
    public $parent1_address_real_idem;
    public $parent1_address_real_postcode;
    public $parent1_address_real_country;
    public $parent1_address_real_subject;
    public $parent1_address_real_region;
    public $parent1_address_real_point;
    public $parent1_address_real;
    public $parent1_contact_phone;
    public $parent1_contact_email;
    public $parent1_job_where;
    public $parent1_job_who;
    public $parent1_job_seniority;
    public $parent1_it_payer;

    public $parent2_surname;
    public $parent2_name;
    public $parent2_patronymic;
    public $parent2_date_of_birth;
    public $parent2_birthplace;
    public $parent2_nationality;
    public $parent2_identity_type;
    public $parent2_identity_sequence;
    public $parent2_identity_number;
    public $parent2_identity_date_issue;
    public $parent2_identity_who_issue;
    public $parent2_identity_who_issue_number;
    public $parent2_address_registration_postcode;
    public $parent2_address_registration_country;
    public $parent2_address_registration_subject;
    public $parent2_address_registration_region;
    public $parent2_address_registration_point;
    public $parent2_address_registration;
    public $parent2_address_real_idem;
    public $parent2_address_real_postcode;
    public $parent2_address_real_country;
    public $parent2_address_real_subject;
    public $parent2_address_real_region;
    public $parent2_address_real_point;
    public $parent2_address_real;
    public $parent2_contact_phone;
    public $parent2_contact_email;
    public $parent2_job_where;
    public $parent2_job_who;
    public $parent2_job_seniority;
    public $parent2_it_payer;

    public $edu_second_prof;
    public $edu_base;
    public $edu_level;
    public $edu_institution;
    public $edu_year_end;
    public $edu_document_type;
    public $edu_document_sequence;
    public $edu_document_number;
    public $edu_medal;
    public $edu_winner;
    public $insurance_certificate;
    public $military_certificate_number;
    public $military_certificate_where;
    public $military_card_number;
    public $lang_eng;
    public $lang_de;
    public $lang_fr;
    public $lang_other;
    public $hostel;
    public $facility;
    public $facility_name;
    public $facility_document;
    public $additional_information;

    public $status = 0;
    public $updated_at;
    public $created_at;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['surname', 'name', 'patronymic'], 'trim'],
            [['surname', 'name', 'patronymic'], 'required'],
            [['surname', 'name', 'patronymic'], 'string', 'min' => 2, 'max' => 255],

            [['birthplace', 'nationality'], 'string', 'max' => 255],

            [['date_of_birth', 'identity_date_issue'], 'required'],
            [['date_of_birth', 'identity_date_issue'], 'date', 'format' => 'yyyy-M-d'],

            [['identity_type', 'identity_sequence', 'identity_number'], 'required'],
            [['identity_type', 'identity_sequence', 'identity_number'], 'myCustomUniquePerson'],
            [['identity_type'], 'string', 'max' => 50],
            [['identity_sequence'], 'string', 'max' => 15],
            [['identity_number'], 'string', 'max' => 30],

            [['identity_who_issue', 'identity_who_issue_number'], 'required'],
            [['identity_who_issue'], 'string', 'max' => 255],
            [['identity_who_issue_number'], 'string', 'max' => 7],

            [['address_registration_postcode'], 'string', 'max' => 6],
            [['address_registration_country', 'address_registration_subject', 'address_registration_point', 'address_registration'], 'required'],
            [['address_registration_country', 'address_registration_subject', 'address_registration_region',
                'address_registration_point', 'address_registration'], 'string', 'max' => 100],
            [['address_registration'], 'safe'],

            [['address_real_idem'], 'integer'],
            [['address_real_postcode'], 'string', 'max' => 6],
            [['address_real_country', 'address_real_subject', 'address_real_region', 'address_real_point', 'address_real'], 'string', 'max' => 100],

            [['contact_phone', 'contact_email', 'job_where', 'job_who'], 'string', 'max' => 255],
            ['contact_email', 'email'],


            [['job_where', 'job_who'], 'string', 'max' => 255],
            ['job_seniority', 'integer', 'min' => 0, 'max' => 99],

            ['it_payer', 'integer', 'min' => 0, 'max' => 1],

            [['edu_second_prof', 'edu_base', 'edu_level', 'edu_year_end',
                'edu_institution', 'edu_document_type', 'edu_document_sequence', 'edu_document_number'], 'required'],

            [['edu_second_prof', 'edu_base', 'edu_year_end', 'edu_medal', 'edu_winner', 'lang_eng', 'lang_de', 'lang_fr', 'hostel', 'facility'], 'integer'],
            [['additional_information'], 'string'],
            [['edu_level'], 'string', 'max' => 3],
            [['edu_institution', 'military_certificate_where', 'lang_other', 'facility_name', 'facility_document'], 'string', 'max' => 255],
            [['edu_document_type'], 'string', 'max' => 8],
            [['edu_document_sequence', 'military_certificate_number', 'military_card_number'], 'string', 'max' => 15],
            [['edu_document_number'], 'string', 'max' => 30],
            [['insurance_certificate'], 'string', 'max' => 14],

            [['parent1_surname', 'parent1_name', 'parent1_patronymic'], 'string', 'min' => 2, 'max' => 255],
            [['parent1_surname', 'parent1_name', 'parent1_patronymic'], 'trim'],
            [['parent1_surname', 'parent1_name', 'parent1_patronymic'], 'required', 'when'=>function ($model) {
                return ($model->parent1_type != '');
            },
                'whenClient' => "function (attribute, value) {
                    return $('#profileform-parent1_type').val() != '';
                }"
            ],
            [['parent1_birthplace', 'parent1_nationality', 'parent1_identity_who_issue', 'parent1_contact_phone', 'parent1_contact_email', 'parent1_job_where', 'parent1_job_who'], 'string', 'max' => 255],
            [['parent1_type', 'parent1_identity_type'], 'string', 'max' => 50],
            [['parent1_identity_sequence'], 'string', 'max' => 15],
            [['parent1_identity_number'], 'string', 'max' => 30],
            [['parent1_identity_who_issue_number'], 'string', 'max' => 7],
            [['parent1_date_of_birth', 'parent1_identity_date_issue'], 'date', 'format' => 'yyyy-M-d'],
            [['parent1_address_registration_postcode', 'parent1_address_real_postcode'], 'string', 'max' => 6],
            [['parent1_address_registration_country', 'parent1_address_registration_subject', 'parent1_address_registration_region', 'parent1_address_registration_point', 'parent1_address_registration', 'parent1_address_real_country', 'parent1_address_real_subject', 'parent1_address_real_region', 'parent1_address_real_point', 'parent1_address_real'], 'string', 'max' => 100],
            ['parent1_contact_email', 'email'],
            ['parent1_it_payer', 'integer', 'min' => 0, 'max' => 1],
            [['parent1_surname', 'parent1_name', 'parent1_patronymic',
                'parent1_identity_type', 'parent1_identity_sequence', 'parent1_identity_number', 'parent1_identity_who_issue', 'parent1_identity_who_issue_number', 'parent1_identity_date_issue',
                'parent1_address_registration_country', 'parent1_address_registration_subject', 'parent1_address_registration_point', 'parent1_address_registration'],
                'required', 'when'=>function ($model) {
                    return $model->parent1_it_payer == 1;
                },
                'whenClient' => "function (attribute, value) {
                    return $('#parent1_it_payer').val() == '1';
                }"
            ],

            [['parent2_surname', 'parent2_name', 'parent2_patronymic'], 'string', 'min' => 2, 'max' => 255],
            [['parent2_surname', 'parent2_name', 'parent2_patronymic'], 'trim'],
            [['parent2_surname', 'parent2_name', 'parent2_patronymic'], 'required', 'when'=>function ($model) {
                return ($model->parent2_type != '');
            },
                'whenClient' => "function (attribute, value) {
                    return $('#profileform-parent2_type').val() != '';
                }"
            ],
            [['parent2_birthplace', 'parent2_nationality', 'parent2_identity_who_issue', 'parent2_contact_phone', 'parent2_contact_email', 'parent2_job_where', 'parent2_job_who'], 'string', 'max' => 255],
            [['parent2_type', 'parent2_identity_type'], 'string', 'max' => 50],
            [['parent2_identity_sequence'], 'string', 'max' => 15],
            [['parent2_identity_number'], 'string', 'max' => 30],
            [['parent2_identity_who_issue_number'], 'string', 'max' => 7],
            [['parent2_address_registration_postcode', 'parent2_address_real_postcode'], 'string', 'max' => 6],
            [['parent2_address_registration_country', 'parent2_address_registration_subject', 'parent2_address_registration_region', 'parent2_address_registration_point', 'parent2_address_registration', 'parent2_address_real_country', 'parent2_address_real_subject', 'parent2_address_real_region', 'parent2_address_real_point', 'parent2_address_real'], 'string', 'max' => 100],
            ['parent2_contact_email', 'email'],
            ['parent2_it_payer', 'integer', 'min' => 0, 'max' => 1],
            [['parent1_surname', 'parent2_name', 'parent2_patronymic',
                'parent2_identity_type', 'parent2_identity_sequence', 'parent2_identity_number', 'parent2_identity_who_issue', 'parent2_identity_who_issue_number', 'parent2_identity_date_issue',
                'parent2_address_registration_country', 'parent2_address_registration_subject', 'parent2_address_registration_point', 'parent2_address_registration'],
                'required', 'when'=>function ($model) {
                return $model->parent2_it_payer == 1;
            },
                'whenClient' => "function (attribute, value) {
                    return $('#parent2_it_payer').val() == '1';
                }"
            ],


            ['nationality', 'default', 'value' => 'Российская Федерация'],
            ['address_registration_country', 'default', 'value' => 'Россия'],
            ['address_real_country', 'default', 'value' => 'Россия'],
            ['address_real_idem', 'default', 'value' => '1'],
            ['job_seniority', 'default', 'value' => '0'],

            ['parent1_address_real_idem', 'default', 'value' => '1'],
            ['parent1_it_payer', 'default', 'value' => '0'],
            ['parent2_address_real_idem', 'default', 'value' => '1'],
            ['parent2_it_payer', 'default', 'value' => '0'],

            [['date_of_birth', 'identity_date_issue'], 'default', 'value' => function ($model, $attribute) {
                return date('Y-m-d', strtotime('-15 years'));
            }],
        ];
    }

    public function myCustomUniquePerson($attribute)
    {

        $person = Person::find()
            ->where(['!=', 'id', $this->id_person])
            ->andWhere(['=', 'identity_type', $this['identity_type']])
            ->andWhere(['=', 'identity_sequence', $this['identity_sequence']])
            ->andWhere(['=', 'identity_number', $this['identity_number']])
            ->one();

        if (!empty($person))
            $this->addError($attribute, 'Персона с данными аттрибутами уже зарегестрирована');

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('profile_form', 'ID'),

            'parent1_type' => Yii::t('profile_form', 'Parent1 type'),
            'id_parent1' => Yii::t('profile_form', 'Id parent1 Person'),
            'parent2_type' => Yii::t('profile_form', 'Parent2 type'),
            'id_parent2' => Yii::t('profile_form', 'Id parent2 Person'),

            'surname' => Yii::t('profile_form', 'Surname'),
            'name' => Yii::t('profile_form', 'Name'),
            'patronymic' => Yii::t('profile_form', 'Patronymic'),
            'date_of_birth' => Yii::t('profile_form', 'Date Of Birth'),
            'birthplace' => Yii::t('profile_form', 'Birthplace'),
            'nationality' => Yii::t('profile_form', 'Nationality'),

            'identity_type' => Yii::t('profile_form', 'Identity Type'),
            'identity_sequence' => Yii::t('profile_form', 'Identity Sequence'),
            'identity_number' => Yii::t('profile_form', 'Identity Number'),
            'identity_date_issue' => Yii::t('profile_form', 'Identity Date Issue'),
            'identity_who_issue' => Yii::t('profile_form', 'Identity Who Issue'),
            'identity_who_issue_number' => Yii::t('profile_form', 'Identity Who Issue Number'),

            'address_registration_postcode' => Yii::t('profile_form', 'Address Registration Postcode'),
            'address_registration_country' => Yii::t('profile_form', 'Address Registration Country'),
            'address_registration_subject' => Yii::t('profile_form', 'Address Registration Subject'),
            'address_registration_region' => Yii::t('profile_form', 'Address Registration Region'),
            'address_registration_point' => Yii::t('profile_form', 'Address Registration Point'),
            'address_registration' => Yii::t('profile_form', 'Address Registration'),
            'address_real_idem' => Yii::t('profile_form', 'Address Real Idem'),
            'address_real_postcode' => Yii::t('profile_form', 'Address Real Postcode'),
            'address_real_country' => Yii::t('profile_form', 'Address Real Country'),
            'address_real_subject' => Yii::t('profile_form', 'Address Real Subject'),
            'address_real_region' => Yii::t('profile_form', 'Address Real Region'),
            'address_real_point' => Yii::t('profile_form', 'Address Real Point'),
            'address_real' => Yii::t('profile_form', 'Address Real'),

            'contact_phone' => Yii::t('profile_form', 'Contact Phone'),
            'contact_email' => Yii::t('profile_form', 'Contact Email'),

            'job_where' => Yii::t('profile_form', 'Job Where'),
            'job_who' => Yii::t('profile_form', 'Job Who'),
            'job_seniority' => Yii::t('profile_form', 'Job Seniority'),

            'edu_second_prof' => Yii::t('profile_form', 'Edu Second Prof'),
            'edu_base' => Yii::t('profile_form', 'Edu Base'),
            'edu_level' => Yii::t('profile_form', 'Edu Level'),
            'edu_institution' => Yii::t('profile_form', 'Edu Institution'),
            'edu_year_end' => Yii::t('profile_form', 'Edu Year End'),
            'edu_document_type' => Yii::t('profile_form', 'Edu Document Type'),
            'edu_document_sequence' => Yii::t('profile_form', 'Edu Document Sequence'),
            'edu_document_number' => Yii::t('profile_form', 'Edu Document Number'),
            'edu_medal' => Yii::t('profile_form', 'Edu Medal'),
            'edu_winner' => Yii::t('profile_form', 'Edu Winner'),
            'insurance_certificate' => Yii::t('profile_form', 'Insurance Certificate'),
            'military_certificate_number' => Yii::t('profile_form', 'Military Certificate Number'),
            'military_certificate_where' => Yii::t('profile_form', 'Military Certificate Where'),
            'military_card_number' => Yii::t('profile_form', 'Military Card Number'),
            'lang_eng' => Yii::t('profile_form', 'Lang Eng'),
            'lang_de' => Yii::t('profile_form', 'Lang De'),
            'lang_fr' => Yii::t('profile_form', 'Lang Fr'),
            'lang_other' => Yii::t('profile_form', 'Lang Other'),
            'hostel' => Yii::t('profile_form', 'Hostel'),
            'facility' => Yii::t('profile_form', 'Facility'),
            'facility_name' => Yii::t('profile_form', 'Facility Name'),
            'facility_document' => Yii::t('profile_form', 'Facility Document'),
            'additional_information' => Yii::t('profile_form', 'Additional Information'),


            'parent1_surname' => Yii::t('profile_form', 'Surname'),
            'parent1_name' => Yii::t('profile_form', 'Name'),
            'parent1_patronymic' => Yii::t('profile_form', 'Patronymic'),
            'parent1_date_of_birth' => Yii::t('profile_form', 'Date Of Birth'),
            'parent1_birthplace' => Yii::t('profile_form', 'Birthplace'),
            'parent1_nationality' => Yii::t('profile_form', 'Nationality'),

            'parent1_identity_type' => Yii::t('profile_form', 'Identity Type'),
            'parent1_identity_sequence' => Yii::t('profile_form', 'Identity Sequence'),
            'parent1_identity_number' => Yii::t('profile_form', 'Identity Number'),
            'parent1_identity_date_issue' => Yii::t('profile_form', 'Identity Date Issue'),
            'parent1_identity_who_issue' => Yii::t('profile_form', 'Identity Who Issue'),
            'parent1_identity_who_issue_number' => Yii::t('profile_form', 'Identity Who Issue Number'),

            'parent1_address_registration_postcode' => Yii::t('profile_form', 'Address Registration Postcode'),
            'parent1_address_registration_country' => Yii::t('profile_form', 'Address Registration Country'),
            'parent1_address_registration_subject' => Yii::t('profile_form', 'Address Registration Subject'),
            'parent1_address_registration_region' => Yii::t('profile_form', 'Address Registration Region'),
            'parent1_address_registration_point' => Yii::t('profile_form', 'Address Registration Point'),
            'parent1_address_registration' => Yii::t('profile_form', 'Address Registration'),
            'parent1_address_real_idem' => Yii::t('profile_form', 'Address Real Idem'),
            'parent1_address_real_postcode' => Yii::t('profile_form', 'Address Real Postcode'),
            'parent1_address_real_country' => Yii::t('profile_form', 'Address Real Country'),
            'parent1_address_real_subject' => Yii::t('profile_form', 'Address Real Subject'),
            'parent1_address_real_region' => Yii::t('profile_form', 'Address Real Region'),
            'parent1_address_real_point' => Yii::t('profile_form', 'Address Real Point'),
            'parent1_address_real' => Yii::t('profile_form', 'Address Real'),

            'parent1_contact_phone' => Yii::t('profile_form', 'Contact Phone'),
            'parent1_contact_email' => Yii::t('profile_form', 'Contact Email'),

            'parent1_job_where' => Yii::t('profile_form', 'Job Where'),
            'parent1_job_who' => Yii::t('profile_form', 'Job Who'),
            'parent1_job_seniority' => Yii::t('profile_form', 'Job Seniority'),

            'parent2_surname' => Yii::t('profile_form', 'Surname'),
            'parent2_name' => Yii::t('profile_form', 'Name'),
            'parent2_patronymic' => Yii::t('profile_form', 'Patronymic'),
            'parent2_date_of_birth' => Yii::t('profile_form', 'Date Of Birth'),
            'parent2_birthplace' => Yii::t('profile_form', 'Birthplace'),
            'parent2_nationality' => Yii::t('profile_form', 'Nationality'),

            'parent2_identity_type' => Yii::t('profile_form', 'Identity Type'),
            'parent2_identity_sequence' => Yii::t('profile_form', 'Identity Sequence'),
            'parent2_identity_number' => Yii::t('profile_form', 'Identity Number'),
            'parent2_identity_date_issue' => Yii::t('profile_form', 'Identity Date Issue'),
            'parent2_identity_who_issue' => Yii::t('profile_form', 'Identity Who Issue'),
            'parent2_identity_who_issue_number' => Yii::t('profile_form', 'Identity Who Issue Number'),

            'parent2_address_registration_postcode' => Yii::t('profile_form', 'Address Registration Postcode'),
            'parent2_address_registration_country' => Yii::t('profile_form', 'Address Registration Country'),
            'parent2_address_registration_subject' => Yii::t('profile_form', 'Address Registration Subject'),
            'parent2_address_registration_region' => Yii::t('profile_form', 'Address Registration Region'),
            'parent2_address_registration_point' => Yii::t('profile_form', 'Address Registration Point'),
            'parent2_address_registration' => Yii::t('profile_form', 'Address Registration'),
            'parent2_address_real_idem' => Yii::t('profile_form', 'Address Real Idem'),
            'parent2_address_real_postcode' => Yii::t('profile_form', 'Address Real Postcode'),
            'parent2_address_real_country' => Yii::t('profile_form', 'Address Real Country'),
            'parent2_address_real_subject' => Yii::t('profile_form', 'Address Real Subject'),
            'parent2_address_real_region' => Yii::t('profile_form', 'Address Real Region'),
            'parent2_address_real_point' => Yii::t('profile_form', 'Address Real Point'),
            'parent2_address_real' => Yii::t('profile_form', 'Address Real'),

            'parent2_contact_phone' => Yii::t('profile_form', 'Contact Phone'),
            'parent2_contact_email' => Yii::t('profile_form', 'Contact Email'),

            'parent2_job_where' => Yii::t('profile_form', 'Job Where'),
            'parent2_job_who' => Yii::t('profile_form', 'Job Who'),
            'parent2_job_seniority' => Yii::t('profile_form', 'Job Seniority'),

            'created_at' => Yii::t('profile_form', 'Created At'),
            'updated_at' => Yii::t('profile_form', 'Updated At'),
        ];
    }

    public function attributeHints()
    {
        return [
        ];
    }

    public function identity_type_array()
    {
        return [
            '' =>'',
            'Паспорт' => 'Паспорт',
            'Заграничный паспорт' => 'Заграничный паспорт',
            'Паспорт иностранного гражданина' => 'Паспорт иностранного гражданина',
            'Свидетельство о рождении' => 'Свидетельство о рождении',
        ];
    }

    public function edu_base_array()
    {
        return [
            9 => '9 кл.',
            11 => '11 кл.'
        ];
    }

    public function edu_level_array()
    {
        return [
            'шк.' => 'Школа',
            'НПО' => 'НПО (училище)',
            'СПО'=>'СПО (техникум, колледж...)',
            'ВУЗ'=>'ВУЗ',
        ];
    }

    public function edu_document_type_array()
    {
        return [
            '' =>'',
            'Аттестат'=>'Аттестат',
            'Диплом'=>'Диплом',
        ];
    }

    public function parent_type_array()
    {
        return [
            '' =>'',
            'Отец'=>'Отец',
            'Мать'=>'Мать',
            'Законный представитель'=>'Законный представитель',
        ];
    }

    private function string_begins_with($needle, $haystack) {
        return (substr($haystack, 0, strlen($needle))==$needle);
    }

    /**
     * Returns the list of attribute names.
     * @param string $pre to find.
     * By default, this method returns all public non-static properties of the class.
     * You may override this method to change the default behavior.
     * @return array list of attribute names.
     */
    private function myattributes($pre)
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                if ($this->string_begins_with($pre, $property->getName()))
                    $names[] = $property->getName();
            }
        }

        return $names;
    }

    /**
     * Returns the attribute names that are safe to be massively assigned in the current scenario.
     * @return string[] safe attribute names
     */
    public function safeMyAttributes($pre)
    {
        $scenario = $this->getScenario();
        $scenarios = $this->scenarios();
        if (!isset($scenarios[$scenario])) {
            return [];
        }
        $attributes = [];
        foreach ($scenarios[$scenario] as $attribute) {
            if (($attribute[0] !== '!')and($this->string_begins_with($pre, $attribute))) {
                $attributes[] = $attribute;
            }
        }

        return $attributes;
    }

    /**
     * Returns attribute values.
     * @param string $pre to remove.
     * @param array $names list of attributes whose value needs to be returned.
     * Defaults to null, meaning all attributes listed in [[attributes()]] will be returned.
     * If it is an array, only the attributes in the array will be returned.
     * @param array $except list of attributes whose value should NOT be returned.
     * @return array attribute values (name => value).
     */
    private function getMyAttributes($pre, $names = null, $except = [])
    {
        $values = [];
        if ($names === null) {
            $names = $this->myattributes($pre);
        }
        foreach ($names as $name) {
            $values[str_replace($pre, '', $name)] = $this->$name;
        }
        foreach ($except as $name) {
            unset($values[$name]);
        }

        return $values;
    }

    /**
     * Sets the attribute values in a massive way.
     * @param string $pre to add.
     * @param array $values attribute values (name => value) to be assigned to the model.
     * @param boolean $safeOnly whether the assignments should only be done to the safe attributes.
     * A safe attribute is one that is associated with a validation rule in the current [[scenario]].
     * @see safeAttributes()
     * @see attributes()
     */
    public function setMyAttributes($pre, $values, $safeOnly = true)
    {
        if (is_array($values)) {
            $attributes = array_flip($safeOnly ? $this->safeMyAttributes($pre) : $this->myattributes($pre));
            foreach ($values as $name => $value) {
                $name = $pre.$name;
                if (isset($attributes[$name])) {
                    $this->$name = $value;
                } elseif ($safeOnly) {
                    $this->onUnsafeAttribute($name, $value);
                }
            }
        }
    }



    public function init()
    {
        $this->id = 0;
        $this->nationality = 'Российская Федерация';
        $this->address_registration_country = 'Россия';
        $this->address_real_country = 'Россия';
        $this->address_real_idem = 1;
        $this->job_seniority = 0;
        $this->parent1_address_real_idem = 1;
        $this->parent2_address_real_idem = 1;
        $this->date_of_birth = date('Y-m-d', strtotime('-15 years'));
        $this->identity_date_issue = date('Y-m-d', strtotime('-1 month'));
    }

    public function loadModel($id)
    {
        $profile = Profile::findById($id);

        if (!empty($profile)) {

            $this->id = $id;

            $this->id_person = $profile->id_person;
            $this->status = $profile->status;
            $this->attributes = $profile->attributes;

            $person = Person::findById($profile->id_person);

            if (!empty($person)) {

                $this->id_person = $person->id;
                $this->attributes = $person->attributes;

                $parent1 = Person::findById($person->id_parent1);

                if (!empty($parent1)) {
                    $this->id_parent1 = $parent1->id;
                    $this->setMyAttributes('parent1_', $parent1->getAttributes());
                }

                $parent2 = Person::findById($person->id_parent2);

                if (!empty($parent2)) {
                    $this->id_parent2 = $parent2->id;
                    $this->setMyAttributes('parent2_', $parent2->getAttributes());
                }

            }

        }

    }



    /**
     * Save application form.
     *
     * @return Profile|null the saved model or null if saving fails
     */
    public function save()
    {

        if ($this->validate()) {

            $person = Person::findById($this->id_person);
            if (empty($person))
                $person = new Person();


            if (trim($this->parent1_type)!='') {
                $parent1 = Person::findById($person->id_parent1);
                if (empty($parent1))
                    $parent1 = new Person();
                $parent1->attributes = $this->getMyAttributes('parent1_');
                $parent1->save();
                $person->id_parent1 = $parent1->id;
            } else {
                $parent1 = Person::findById($person->id_parent1);
                if (!empty($parent1))
                    $parent1->delete();
                $person->id_parent1 = null;
            }

            if (trim($this->parent2_type)!='') {
                $parent2 = Person::findById($person->id_parent2);
                if (empty($parent2))
                    $parent2 = new Person();
                $parent2->attributes = $this->getMyAttributes('parent2_');
                $parent2->save();
                $person->id_parent2 = $parent2->id;
            } else {
                $parent2 = Person::findById($person->id_parent2);
                if (!empty($parent2))
                    $parent2->delete();
                $person->id_parent2 = null;
            }

            $person->attributes = $this->attributes;

            if ($person->save()) {

                $this->id_person = $person->id;

                $profile = Profile::findById($this->id);

                if (empty($profile))
                    $profile = new Profile();

                $profile->attributes = $this->attributes;
                $profile->id_person = $person->id;
                $profile->status = $this->status;

                if ($profile->validate()) {
                    $profile->save();
                    $this->id = $profile->id;

                    $specs = Yii::$app->request->post('spec');
                    $SpecArray = array(); $i = 0;

                    if (!empty($specs))
                        foreach ($specs as $id=>$spec) {
                            if($spec != 'none') {
                                $SpecArray[$i]['id_profile'] = $profile->id;
                                $SpecArray[$i]['id_spec'] = $id;
                                $spec == 'form_fulltime' ? $SpecArray[$i]['form_fulltime'] = 1 : $SpecArray[$i]['form_fulltime'] = 0;
                                $spec == 'form_extramural' ? $SpecArray[$i]['form_extramural'] = 1 : $SpecArray[$i]['form_extramural'] = 0;
                                $SpecArray[$i]['priority'] = $i+1;
                                $i++;
                            }
                        }

                    Yii::$app->db->createCommand()->delete('profile_spec', 'id_profile=:id', [':id'=>$profile->id])
                        ->execute();

                   if (!empty($SpecArray))
                       Yii::$app->db->createCommand()->batchInsert('profile_spec', ['id_profile', 'id_spec', 'form_fulltime', 'form_extramural', 'priority'], $SpecArray)
                            ->execute();

                    return true;

                } else {

                    return false;

                }

            }

        }

        return false;
    }

} 
<?php

use yii\db\Schema;
use yii\db\Migration;

class m150928_125051_create_person_table extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%person}}', [
            'id' => $this->primaryKey(),

            'parent1_type' => $this->string(50),
            'id_parent1' => $this->integer(),
            'parent2_type' => $this->string(50),
            'id_parent2' => $this->integer(),

            'surname' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'patronymic' => $this->string()->notNull(),
            'date_of_birth' => $this->date(),
            'birthplace' => $this->string(),
            'nationality' => $this->string(),

            // Документ, удостоверяющий личность
            'identity_type' => $this->string(50),
            'identity_sequence' => $this->string(15),
            'identity_number' => $this->string(30),
            'identity_date_issue' => $this->date(), // Дата выдачи
            'identity_who_issue' => $this->string(),    // Кем выдан
            'identity_who_issue_number' => $this->string(7), // Код подразделения

            // Адрес регистрации и фактического проживания, если отличаются
            'address_registration_postcode' => $this->string(6),
            'address_registration_country' => $this->string(100)->defaultValue('Россия'),
            'address_registration_subject' => $this->string(100), // Субъект (Край, Область, Республика)
            'address_registration_region' => $this->string(100), //Район субъекта
            'address_registration_point' => $this->string(100), //Населенный пункт (город, поселок, деревня)
            'address_registration' => $this->string(100), //Улица, дом, квартира
            'address_real_idem' => $this->integer(1)->defaultValue(1),
            'address_real_postcode' => $this->string(6),
            'address_real_country' => $this->string(100),
            'address_real_subject' => $this->string(100),
            'address_real_region' => $this->string(100),
            'address_real_point' => $this->string(100),
            'address_real' => $this->string(100),

            // Контактные данные
            'contact_phone' => $this->string(),
            'contact_email' => $this->string(),

            // Опыт работы
            'job_where' => $this->string(), // Где работает
            'job_who' => $this->string(), // Кем работает
            'job_seniority' => $this->integer(2), // Трудовой стаж

            'it_payer' => $this->integer(1)->defaultValue(0), //Плательщик, указывается в договорах на обучение или дополнительные услуги.

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('person_fio', '{{%person}}', ['surname', 'name', 'patronymic']);
        $this->createIndex('person_identity_number', '{{%person}}', ['identity_sequence', 'identity_number']);

    }

    public function down()
    {
        $this->dropIndex('person_fio', '{{%person}}');
        $this->dropIndex('person_identity_number', '{{%person}}');

        $this->dropTable('{{%person}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}

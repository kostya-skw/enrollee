<?php

use yii\db\Schema;
use yii\db\Migration;

class m150924_072354_create_profile_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),

            'id_person' => $this->integer(),

            // Среднее профессиональное образование получаю впервые?
            'edu_second_prof' => $this->integer(1)->defaultValue(1),

            // Предыдущее образование
            'edu_base' => $this->integer(2)->notNull(), // 9 / 11 классов
            'edu_level' => $this->string(3)->notNull(), // шк./ НПО / СПО / ВУЗ
            'edu_institution' => $this->string()->notNull(), // Образовательное учреждение
            'edu_year_end' => $this->integer(4)->notNull(),
            'edu_document_type' => $this->string(8)->notNull(),
            'edu_document_sequence' => $this->string(15)->notNull(),
            'edu_document_number' => $this->string(30)->notNull(),
            'edu_medal' => $this->integer(1)->defaultValue(0), // Медаль (аттестат, диплом «с отличием»)
            'edu_winner' => $this->integer(1)->defaultValue(0), // Победитель всероссийских олимпиад (член сборной)

            // Документы
            'insurance_certificate' => $this->string(14), // Пенсионное (страховое) свидетельство, номер
            'military_certificate_number' => $this->string(15), // Приписное свидетельство, номер
            'military_certificate_where' => $this->string(), // Приписное свидетельство, где стоит на в/у
            'military_card_number' => $this->string(15), // Военный билет, номер

            // Владение языками
            'lang_eng' => $this->integer(1)->defaultValue(0),
            'lang_de' => $this->integer(1)->defaultValue(0),
            'lang_fr' => $this->integer(1)->defaultValue(0),
            'lang_other' => $this->string(),

            // Общежитие
            'hostel' => $this->integer(1)->defaultValue(0),

            // Льготы
            'facility' => $this->integer(1)->defaultValue(0), // Нуждается в льготах
            'facility_name' => $this->string(),               // Наименование льготы
            'facility_document' => $this->string(),           // Документ, предоставляющий право на льготы

            // Дополнительная ифнормация
            'additional_information' => $this->text(),

            'status' => $this->integer()->defaultValue(0),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('id_person', '{{%profile}}', 'id_person');

    }

    public function down()
    {
        $this->dropIndex('id_person', '{{%profile}}');

        $this->dropTable('{{%profile}}');
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

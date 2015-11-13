<?php

use yii\db\Schema;
use yii\db\Migration;

class m151026_083410_spec extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%spec}}', [
            'id' => $this->primaryKey(),

            'code' => $this->string(30)->notNull(),
            'name' => $this->string()->notNull(),

            'form_fulltime' => $this->integer(1)->defaultValue(1), //форма обучения очная
            'form_extramural' => $this->integer(1)->defaultValue(0), //форма обучения заочная
            'base_9' => $this->integer(1)->defaultValue(1), //база 9
            'base_11' => $this->integer(1)->defaultValue(1), //база 11

            'active' => $this->integer(1)->defaultValue(1),

        ], $tableOptions);

        $this->createIndex('code', '{{%spec}}', ['code']);


        $this->createTable('{{%profile_spec}}', [
            'id' => $this->primaryKey(),

            'id_profile' => $this->integer(),
            'id_spec' => $this->integer(),
            'form_fulltime' => $this->integer(1)->defaultValue(0), //форма обучения очная
            'form_extramural' => $this->integer(1)->defaultValue(0), //форма обучения заочная
            'priority' => $this->integer(2), //Приоритет

        ], $tableOptions);

        $this->createIndex('id_profile', '{{%profile_spec}}', ['id_profile']);

    }

    public function down()
    {
        $this->dropIndex('code', '{{%spec}}');
        $this->dropTable('{{%spec}}');

        $this->dropIndex('id_profile', '{{%profile_spec}}');
        $this->dropTable('{{%profile_spec}}');

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

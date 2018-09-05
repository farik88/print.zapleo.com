<?php

use yii\db\Migration;

class m170215_091806_change_user_table extends Migration
{
    public function up()
    {
        $this->renameTable('user','users');
    }

    public function down()
    {
        $this->renameTable('users','user');
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

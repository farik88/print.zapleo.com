<?php

use yii\db\Migration;

class m170518_041714_add_phone_in_users_table extends Migration
{
    public function up()
    {
        $this->addColumn('users','phone',$this->string(15)->null());
    }

    public function down()
    {
        echo "m170518_041714_add_phone_in_users_table cannot be reverted.\n";

        return false;
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

<?php

use yii\db\Migration;

class m170421_091006_edit_folder_id_in_resources extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('resources','folder_id',$this->integer()->null());
    }

    public function safeDown()
    {
        echo "m170421_091006_edit_folder_id_in_resources cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170315_073037_removeColum_in_resources_type_id_and_folder_id extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('resources','type_id');
    }

    public function safeDown()
    {
        echo "m170315_073037_removeColum_in_resources_type_id_and_folder_id cannot be reverted.\n";

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

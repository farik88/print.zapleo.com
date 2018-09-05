<?php

use yii\db\Migration;

class m170302_085626_addColum_last_active_in_users extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users','last_active',$this->dateTime()->null());
    }

    public function safeDown()
    {
        echo "m170302_085626_addColum_last_active_in_users cannot be reverted.\n";

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

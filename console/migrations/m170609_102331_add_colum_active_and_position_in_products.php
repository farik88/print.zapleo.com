<?php

use yii\db\Migration;

class m170609_102331_add_colum_active_and_position_in_products extends Migration
{
    public function safeUp()
    {
        $this->addColumn('products','active',$this->integer()->defaultValue(1));
        $this->addColumn('products','position',$this->integer()->null());
    }

    public function safeDown()
    {
        echo "m170609_102331_add_colum_active_and_position_in_products cannot be reverted.\n";

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

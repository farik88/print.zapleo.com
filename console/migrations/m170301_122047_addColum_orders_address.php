<?php

use yii\db\Migration;

class m170301_122047_addColum_orders_address extends Migration
{
    public function safeUp()
    {
        $this->addColumn('orders','address',$this->string()->notNull());
    }

    public function safeDown()
    {
        echo "m170301_122047_addColum_orders_address cannot be reverted.\n";

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

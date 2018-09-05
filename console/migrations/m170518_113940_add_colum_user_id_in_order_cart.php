<?php

use yii\db\Migration;

class m170518_113940_add_colum_user_id_in_order_cart extends Migration
{
    public function safeUp()
    {
        $this->addColumn('order_cart','user_id',$this->integer()->null());
        $this->alterColumn('order_cart','user_hash',$this->string()->null());
    }

    public function safeDown()
    {
        echo "m170518_113940_add_colum_user_id_in_order_cart cannot be reverted.\n";

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

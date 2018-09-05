<?php

use yii\db\Migration;

class m170518_112831_remove_table_order_product_alter_table_cart extends Migration
{
    public function safeUp()
    {
        $this->execute("SET foreign_key_checks = 0;");

        $this->dropTable('order_product');
        $this->renameTable('carts','order_cart');


        $this->execute("SET foreign_key_checks = 1;");

    }

    public function safeDown()
    {
        echo "m170518_112831_remove_table_order_product_alter_table_cart cannot be reverted.\n";

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

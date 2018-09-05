<?php

use yii\db\Migration;

class m170530_075645_alter_column_total_to_float extends Migration
{
    public function safeUp()
    {
        $this->alterColumn("order_cart", "total", "FLOAT(10,2) NOT NULL");
        $this->alterColumn("orders", "total", "FLOAT(10,2) NOT NULL");
    }

    public function safeDown()
    {
        $this->alterColumn("orders", "total", "INT NOT NULL");
        $this->alterColumn("order_cart", "total", "INT NOT NULL");
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

<?php

use yii\db\Migration;

class m170523_043851_add_coupon_id_in_table_order_cart extends Migration
{
    public function up()
    {
        $this->addColumn('order_cart','coupon_id',$this->integer()->null());

        $this->execute("ALTER TABLE `order_cart` ADD FOREIGN KEY (coupon_id) REFERENCES `coupons` (`id`) ON UPDATE SET NULL ON DELETE SET NULL;
");
    }

    public function down()
    {
        echo "m170523_043851_add_coupon_id_in_table_order_cart cannot be reverted.\n";

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

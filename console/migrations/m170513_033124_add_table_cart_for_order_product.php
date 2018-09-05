<?php

use yii\db\Migration;

class m170513_033124_add_table_cart_for_order_product extends Migration
{
    public function safeUp()
    {
        $this->createTable('carts', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->null(),
            'image_id' => $this->integer()->notNull(),
            'total' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
        ]);

        $this->addColumn('carts','created_at','integer not null');
        $this->addColumn('carts','updated_at','integer not null');

        $this->execute("ALTER TABLE `carts` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `carts` ADD FOREIGN KEY (order_id) REFERENCES `orders` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `carts` ADD FOREIGN KEY (image_id) REFERENCES `images` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        echo "m170513_033124_add_table_cart_for_order_product cannot be reverted.\n";

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

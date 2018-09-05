<?php

use yii\db\Migration;

class m170215_113240_initial_migration_database extends Migration
{
    public function safeUp()
    {
        $this->createTable('coupons', [
            'id' => $this->primaryKey(),
            'hash' => $this->string()->notNull(),
            'sale_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('coupon_label', [
            'id' => $this->primaryKey(),
            'coupon_id' => $this->integer()->notNull(),
            'label_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('covers', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'sale_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('deliveries', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'file_id' => $this->integer()->notNull(),
            'comment' => $this->text(),
            'price' => $this->integer()->notNull(),
            'active' => $this->integer()->notNull(),
        ]);

        $this->createTable('files', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'ext' => $this->string()->notNull(),
        ]);

        $this->createTable('folders', [
            'id' => $this->primaryKey(),
            'parent_folder' => $this->integer()->null(),
        ]);

        $this->createTable('images', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'ext' => $this->string()->notNull(),
        ]);

        $this->createTable('labels', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'sale_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('markings', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'delivery_id' => $this->integer()->notNull(),
            'payment_id' => $this->integer()->notNull(),
            'coupon_id' => $this->integer()->null(),
            'user_id' => $this->integer()->notNull(),
            'total' => $this->integer()->notNull(),
            'comment' => $this->text(),
            'status_payment' => $this->integer()->notNull(),
            'status_delivery' => $this->integer()->notNull(),
            'data' => $this->dateTime()->notNull(),
        ]);

        $this->createTable('order_product', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->null(),
            'image_id' => $this->integer()->notNull(),
            'total' => $this->integer()->notNull(),
            'count' => $this->integer()->notNull(),
        ]);

        $this->createTable('payments', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
        ]);

        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->integer()->notNull(),
            'sale_id' => $this->integer()->null(),
            'file_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('product_coupon', [
            'id' => $this->primaryKey(),
            'coupon_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('product_cover', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'cover_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('product_label', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'label_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('resources', [
            'id' => $this->primaryKey(),
            'folder_id' => $this->integer()->notNull(),
        ]);

        $this->createTable('sales', [
            'id' => $this->primaryKey(),
            'percent' => $this->integer()->notNull(),
            'data_start' => $this->dateTime()->notNull(),
            'data_end' => $this->dateTime()->notNull(),
        ]);

        $this->createTable('coupon_cover', [
            'id' => $this->primaryKey(),
            'coupon_id' => $this->integer()->notNull(),
            'cover_id' => $this->integer()->notNull(),
        ]);

        $this->execute('ALTER TABLE `markings` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `orders` ADD FOREIGN KEY (delivery_id) REFERENCES `deliveries` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `orders` ADD FOREIGN KEY (coupon_id) REFERENCES `coupons` (`id`) ON UPDATE SET NULL ON DELETE SET NULL;
ALTER TABLE `orders` ADD FOREIGN KEY (user_id) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `orders` ADD FOREIGN KEY (payment_id) REFERENCES `payments` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `products` ADD FOREIGN KEY (sale_id) REFERENCES `sales` (`id`) ON UPDATE SET NULL ON DELETE SET NULL;
ALTER TABLE `products` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `deliveries` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `resources` ADD FOREIGN KEY (folder_id) REFERENCES `folders` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `covers` ADD FOREIGN KEY (sale_id) REFERENCES `sales` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `order_product` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `order_product` ADD FOREIGN KEY (order_id) REFERENCES `orders` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `order_product` ADD FOREIGN KEY (image_id) REFERENCES `images` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `product_label` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `product_label` ADD FOREIGN KEY (label_id) REFERENCES `labels` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `coupons` ADD FOREIGN KEY (sale_id) REFERENCES `sales` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `product_coupon` ADD FOREIGN KEY (coupon_id) REFERENCES `coupons` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `product_coupon` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `product_cover` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `product_cover` ADD FOREIGN KEY (cover_id) REFERENCES `covers` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `coupon_cover` ADD FOREIGN KEY (coupon_id) REFERENCES `coupons` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `coupon_cover` ADD FOREIGN KEY (cover_id) REFERENCES `covers` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `coupon_label` ADD FOREIGN KEY (label_id) REFERENCES `labels` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `coupon_label` ADD FOREIGN KEY (coupon_id) REFERENCES `coupons` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `labels` ADD FOREIGN KEY (sale_id) REFERENCES `sales` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
');

    }

    public function safeDown()
    {
        echo "m170215_113240_initial_migration_database cannot be reverted.\n";

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

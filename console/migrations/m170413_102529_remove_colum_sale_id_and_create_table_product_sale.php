<?php

use yii\db\Migration;

class m170413_102529_remove_colum_sale_id_and_create_table_product_sale extends Migration
{
    public function up()
    {
        $this->dropForeignKey('products_ibfk_1','products');
        $this->dropColumn('products','sale_id');

        $this->createTable('product_sale', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'sale_id' => $this->integer()->notNull(),
        ]);

        $this->execute("
ALTER TABLE `product_sale` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `product_sale` ADD FOREIGN KEY (sale_id) REFERENCES `sales` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
");
    }

    public function down()
    {
        echo "m170413_102529_remove_colum_sale_id_and_create_table_product_sale cannot be reverted.\n";

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

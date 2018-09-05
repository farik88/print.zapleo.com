<?php

use yii\db\Migration;

class m170418_130024_create_table_product_marking extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('markings_ibfk_1','markings');
        $this->dropColumn('markings','product_id');

        $this->createTable('product_marking', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'marking_id' => $this->integer()->notNull(),
        ]);

        $this->execute("
ALTER TABLE `product_marking` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `product_marking` ADD FOREIGN KEY (marking_id) REFERENCES `markings` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        echo "m170418_130024_create_table_product_marking cannot be reverted.\n";

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

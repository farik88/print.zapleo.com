<?php

use yii\db\Migration;

class m170302_121646_operation_products_color extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('products_ibfk_2','products');

        $this->dropColumn('products','file_id');

        $this->createTable('colors',[
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
        ]);

        $this->createTable('product_color',[
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'color_id' => $this->integer()->notNull(),
            'file_id' => $this->integer()->notNull(),
        ]);

        $this->execute('ALTER TABLE `product_color` ADD FOREIGN KEY (product_id) REFERENCES `products` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `product_color` ADD FOREIGN KEY (color_id) REFERENCES `colors` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
');
    }

    public function safeDown()
    {
        echo "m170302_121646_operation_products_color cannot be reverted.\n";

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

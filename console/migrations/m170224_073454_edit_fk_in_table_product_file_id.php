<?php

use yii\db\Migration;

class m170224_073454_edit_fk_in_table_product_file_id extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('products_ibfk_2','products');
       $this->execute('ALTER TABLE `products` ADD FOREIGN KEY (`file_id`) REFERENCES `files`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;');
    }

    public function safeDown()
    {
        echo "m170224_073454_edit_fk_in_table_product_file_id cannot be reverted.\n";

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

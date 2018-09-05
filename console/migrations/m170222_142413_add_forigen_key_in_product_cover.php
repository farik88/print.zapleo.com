<?php

use yii\db\Migration;

class m170222_142413_add_forigen_key_in_product_cover extends Migration
{
    public function safeUp()
    {
        $this->addColumn('product_cover','file_id','integer not null');

        $this->execute('ALTER TABLE `product_cover` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;');
    }

    public function safeDown()
    {
        echo "m170222_142413_add_forigen_key_in_product_cover cannot be reverted.\n";

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

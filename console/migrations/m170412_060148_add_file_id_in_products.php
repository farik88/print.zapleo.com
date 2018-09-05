<?php

use yii\db\Migration;

class m170412_060148_add_file_id_in_products extends Migration
{
    public function safeUp()
    {

        $this->addColumn('products','file_id',$this->integer()->notNull());
        $this->addColumn('products','wspace_width',$this->integer());
        $this->addColumn('products','wspace_height',$this->integer());
        $this->addColumn('products','wspace_width3d',$this->integer());
        $this->addColumn('products','wspace_height3d',$this->integer());

        $this->execute('ALTER TABLE `products` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
    }

    public function safeDown()
    {
        $this->dropForeignKey('products_ibfk_2','products');
        $this->dropColumn('products','file_id');
        $this->dropColumn('products','wspace_width');
        $this->dropColumn('products','wspace_height');
        $this->dropColumn('products','wspace_width3d');
        $this->dropColumn('products','wspace_height3d');

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

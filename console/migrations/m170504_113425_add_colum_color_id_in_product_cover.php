<?php

use yii\db\Migration;

class m170504_113425_add_colum_color_id_in_product_cover extends Migration
{
    public function safeUp()
    {
        $this->addColumn('product_cover','color_id',$this->integer());

        $this->execute("ALTER TABLE `product_cover` ADD FOREIGN KEY (color_id) REFERENCES `colors` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        echo "m170504_113425_add_colum_color_id_in_product_cover cannot be reverted.\n";

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

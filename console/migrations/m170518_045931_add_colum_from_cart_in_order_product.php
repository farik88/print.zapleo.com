<?php

use yii\db\Migration;

class m170518_045931_add_colum_from_cart_in_order_product extends Migration
{
    public function safeUp()
    {
        $this->addColumn('order_product','cover_id',$this->integer()->notNull());
        $this->addColumn('order_product','color_id',$this->integer()->notNull());

        $this->execute("ALTER TABLE `order_product` ADD FOREIGN KEY (cover_id) REFERENCES `covers` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `order_product` ADD FOREIGN KEY (color_id) REFERENCES `colors` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        echo "m170518_045931_add_colum_from_cart_in_order_product cannot be reverted.\n";

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

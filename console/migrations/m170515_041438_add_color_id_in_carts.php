<?php

use yii\db\Migration;

class m170515_041438_add_color_id_in_carts extends Migration
{
    public function up()
    {
        $this->addColumn('carts','color_id',$this->integer()->notNull());

        $this->execute("ALTER TABLE `carts` ADD FOREIGN KEY (color_id) REFERENCES `colors` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function down()
    {
        echo "m170515_041438_add_color_id_in_carts cannot be reverted.\n";

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

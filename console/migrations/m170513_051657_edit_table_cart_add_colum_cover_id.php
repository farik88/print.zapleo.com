<?php

use yii\db\Migration;

class m170513_051657_edit_table_cart_add_colum_cover_id extends Migration
{
    public function up()
    {
        $this->addColumn('carts','cover_id',$this->integer()->notNull());

        $this->execute("ALTER TABLE `carts` ADD FOREIGN KEY (cover_id) REFERENCES `covers` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function down()
    {
        echo "m170513_051657_edit_table_cart_add_colum_cover_id cannot be reverted.\n";

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

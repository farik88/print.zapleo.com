<?php

use yii\db\Migration;

class m170513_091410_add_colum_user_id_in_carts extends Migration
{
    public function safeUp()
    {
        $this->addColumn('carts','user_id',$this->integer()->notNull());

        $this->execute("ALTER TABLE `carts` ADD FOREIGN KEY (user_id) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        echo "m170513_091410_add_colum_user_id_in_carts cannot be reverted.\n";

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

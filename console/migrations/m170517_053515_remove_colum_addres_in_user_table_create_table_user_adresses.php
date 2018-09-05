<?php

use yii\db\Migration;

class m170517_053515_remove_colum_addres_in_user_table_create_table_user_adresses extends Migration
{
    public function safeUp()
    {
        $this->createTable('user_address', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'address' => $this->string()->notNull(),
        ]);

        $this->execute('ALTER TABLE `user_address` ADD FOREIGN KEY (user_id) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
');
    }

    public function safeDown()
    {
        echo "m170517_053515_remove_colum_addres_in_user_table_create_table_user_adresses cannot be reverted.\n";

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

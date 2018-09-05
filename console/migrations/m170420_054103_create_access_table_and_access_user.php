<?php

use yii\db\Migration;

class m170420_054103_create_access_table_and_access_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('accesses', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'value' => $this->integer()->notNull(),
        ]);
        $this->addColumn('accesses','created_at','integer not null');
        $this->addColumn('accesses','updated_at','integer not null');
        $this->addColumn('accesses','created_by','integer not null');
        $this->addColumn('accesses','updated_by','integer not null');

        $this->createTable('access_user', [
            'id' => $this->primaryKey(),
            'access_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->execute("ALTER TABLE `access_user` ADD FOREIGN KEY (access_id) REFERENCES `accesses` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `access_user` ADD FOREIGN KEY (user_id) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        echo "m170420_054103_create_access_table_and_access_user cannot be reverted.\n";

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

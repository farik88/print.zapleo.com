<?php

use yii\db\Migration;

class m170418_060918_add_table_languages extends Migration
{
    public function safeUp()
    {
        $this->createTable('languages', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'active'  => $this->integer(),
            'comment' => $this->text(),
            'file_id' => $this->integer()->notNull(),
        ]);

        $this->execute("ALTER TABLE `languages` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");

        $this->addColumn('languages','created_at','integer not null');
        $this->addColumn('languages','updated_at','integer not null');
        $this->addColumn('languages','created_by','integer not null');
        $this->addColumn('languages','updated_by','integer not null');
    }

    public function safeDown()
    {
        $this->dropForeignKey('languages_ibfk_1','languages');

        $this->dropTable('languages');

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

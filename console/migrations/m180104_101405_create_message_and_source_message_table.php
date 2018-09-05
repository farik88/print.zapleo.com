<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message_and_source_message`.
 */
class m180104_101405_create_message_and_source_message_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->truncateTable('languages');
        $this->insert('languages', [
            'title' => 'Русский',
            'active' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 0,
            'updated_by' => 0,
            'iso_code' => 'ru_RU',
            'is_default' => 1,
            'url' => 'ru'

        ]);
        $this->insert('languages', [
            'title' => 'English',
            'active' => 1,
            'created_at' => time(),
            'updated_at' => time(),
            'created_by' => 0,
            'updated_by' => 0,
            'iso_code' => 'en_US',
            'url' => 'en'
        ]);

        //$this->dropForeignKey('fk_message_source_message','message');
        //$this->dropTable('message');
        //$this->dropTable('source_message');

        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'language' => $this->string(16),
            'translation' => $this->text()
        ]);

        $this->createTable('source_message', [
            'id' => $this->primaryKey(),
            'category' => $this->string(),
            'message' => $this->text()
        ]);

        $this->addForeignKey('fk_message_source_message', 'message', 'id', 'source_message', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_message_source_message','message');
        $this->dropTable('message');
        $this->dropTable('source_message');
    }
}

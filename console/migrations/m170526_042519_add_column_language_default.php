<?php

use yii\db\Migration;

class m170526_042519_add_column_language_default extends Migration
{
    /**
     * TODO back/languages is broken.
     * just add for russian language exists file_id or rework view for languages with NOT REQUIRED file_id
     */
    public function safeUp()
    {
        $this->alterColumn('languages', 'file_id', 'int null default null');
        $this->addColumn('languages', 'is_default', 'INT NULL DEFAULT NULL');
        $this->addColumn('languages', 'iso_code', 'VARCHAR(10) NOT NULL');
        $this->insert("languages", [
            'title' => 'Русский',
            'active' => 1,
            'created_at' => 1,
            'updated_at' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'iso_code' => 'ru_RU',
            'is_default' => 1

        ]);
    }

    public function safeDown()
    {
        $this->delete("language", [ 'iso_code' => 'ru_RU', 'created_at' => 1 ]);
        $this->dropColumn("languages", 'iso_code');
        $this->dropColumn("languages", 'is_default');
        $this->alterColumn('languages', 'file_id', 'int not null');
    }
}

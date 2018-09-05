<?php

use yii\db\Migration;

class m170513_121308_add_table_tmp_user_files extends Migration
{
    public function safeUp()
    {
        //for frontend
        //table for temp files, each one has been loaded by user and must be removed after order creation
        //files in the table saving into special directory
        $this->createTable("user_tmp_files",[
            'id' => $this->primaryKey(8), //big int
            'name' => $this->string()->notNull(),
            'ext' => $this->string()->notNull(),
            'owner_hash' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

    }

    public function safeDown()
    {
        $this->dropTable("user_tmp_files");
    }
}

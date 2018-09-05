<?php

use yii\db\Migration;

class m170518_122655_create_table_settings extends Migration
{
    public function up()
    {
        $this->createTable("settings", [
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
            'description' => $this->text()->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable("settings");
    }
}

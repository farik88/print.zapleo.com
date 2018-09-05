<?php

use yii\db\Migration;

class m170314_115632_edit_table_resources extends Migration
{
    public function safeUp()
    {
        $this->addColumn('resources','name',$this->string()->notNull());
        $this->addColumn('resources','ext',$this->string()->notNull());
        $this->addColumn('resources','title',$this->string()->notNull());
        $this->addColumn('resources','type_id',$this->integer()->notNull());

        $this->addColumn('folders','name',$this->string()->notNull());
        $this->addColumn('folders','type_id',$this->integer()->notNull());
    }

    public function safeDown()
    {
        echo "m170314_115632_edit_table_resources cannot be reverted.\n";

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

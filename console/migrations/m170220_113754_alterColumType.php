<?php

use yii\db\Migration;

class m170220_113754_alterColumType extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('labels', 'sale_id', $this->integer()->null());

        $this->alterColumn('covers', 'sale_id', $this->integer()->null());
    }

    public function safeDown()
    {
        echo "m170220_113754_alterColumType cannot be reverted.\n";

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

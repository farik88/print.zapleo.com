<?php

use yii\db\Migration;

class m170216_145420_add_colum_in_payments extends Migration
{
    public function safeUp()
    {
        $this->addColumn('payments','created_at','integer not null');
        $this->addColumn('payments','updated_at','integer not null');
    }

    public function safeDown()
    {
        echo "m170216_145420_add_colum_in_payments cannot be reverted.\n";

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

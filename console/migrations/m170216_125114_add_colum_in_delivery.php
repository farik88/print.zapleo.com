<?php

use yii\db\Migration;

class m170216_125114_add_colum_in_delivery extends Migration
{
    public function safeUp()
    {
        $this->addColumn('deliveries','created_at','integer not null');
        $this->addColumn('deliveries','updated_at','integer not null');
    }

    public function safeDown()
    {
        echo "m170216_125114_add_colum_in_delivery cannot be reverted.\n";

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

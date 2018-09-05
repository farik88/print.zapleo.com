<?php

use yii\db\Migration;

class m170301_101432_alertColum_sales extends Migration
{
    public function safeUp()
    {
        $this->addColumn('sales','type',$this->integer()->notNull());

        $this->renameColumn('sales','percent','value');
    }

    public function safeDown()
    {
        echo "m170301_101432_alertColum_sales cannot be reverted.\n";

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

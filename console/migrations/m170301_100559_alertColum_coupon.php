<?php

use yii\db\Migration;

class m170301_100559_alertColum_coupon extends Migration
{
    public function safeUp()
    {
        $this->addColumn('coupons','type',$this->integer()->notNull());

        $this->renameColumn('coupons','percent','value');

    }

    public function safeDown()
    {
        echo "m170301_100559_alertColum_coupon cannot be reverted.\n";

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

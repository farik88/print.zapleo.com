<?php

use yii\db\Migration;

class m170522_075948_add_type_coupon_in_table_coupons extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('coupons','type','discount_type');
        $this->addColumn('coupons','type',$this->smallInteger()->null());
    }

    public function safeDown()
    {
        echo "m170522_075948_add_type_coupon_in_table_coupons cannot be reverted.\n";

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

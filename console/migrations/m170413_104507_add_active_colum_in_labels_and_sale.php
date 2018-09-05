<?php

use yii\db\Migration;

class m170413_104507_add_active_colum_in_labels_and_sale extends Migration
{
    public function safeUp()
    {
        $this->addColumn('coupons','active',$this->integer());
        $this->addColumn('sales','active',$this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('coupons','active');
        $this->dropColumn('sales','active');

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

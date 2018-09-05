<?php

use yii\db\Migration;

class m170224_120826_edit_fk_in_table_coupons_addcolum_percent extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('coupons_ibfk_1','coupons');

        $this->dropColumn('coupons','sale_id');

        $this->addColumn('coupons','percent',$this->integer()->notNull());

    }

    public function safeDown()
    {
        echo "m170224_120826_edit_fk_in_table_coupons_addcolum_percent cannot be reverted.\n";

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

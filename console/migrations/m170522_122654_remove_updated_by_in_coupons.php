<?php

use yii\db\Migration;

class m170522_122654_remove_updated_by_in_coupons extends Migration
{
    public function up()
    {
        $this->dropColumn('coupons','updated_by');
    }

    public function down()
    {
        echo "m170522_122654_remove_updated_by_in_coupons cannot be reverted.\n";

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

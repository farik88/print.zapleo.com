<?php

use yii\db\Migration;

class m170222_124846_edit_type_colum_in_table_sales extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('sales', 'data_start', $this->dateTime()->null());

        $this->alterColumn('sales', 'data_end', $this->dateTime()->null());
    }

    public function safeDown()
    {
        echo "m170222_124846_edit_type_colum_in_table_sales cannot be reverted.\n";

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

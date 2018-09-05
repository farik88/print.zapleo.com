<?php

use yii\db\Migration;

class m170529_121524_added_column_is_new_to_users_and_orders extends Migration
{
    public function safeUp()
    {
        $this->addColumn("users", 'is_old', "INT NULL DEFAULT NULL");
        $this->addColumn("orders", 'is_old', "INT NULL DEFAULT NULL" );
    }

    public function safeDown()
    {
        $this->dropColumn("orders", 'is_old');
        $this->dropColumn("users", 'is_old');
    }
}

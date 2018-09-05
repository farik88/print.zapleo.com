<?php

use yii\db\Migration;

class m170418_071102_edit_user_table_add_colum_dispatch extends Migration
{
    public function safeUp()
    {
        $this->addColumn('users','dispatch',$this->integer()->defaultValue(1));
    }

    public function safeDown()
    {
      $this->dropColumn('users','dispatch');

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

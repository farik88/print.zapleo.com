<?php

use yii\db\Migration;

class m170511_063435_add_colum_in_covers extends Migration
{
    public function safeUp()
    {
        $this->addColumn('covers','title',$this->string());
    }

    public function safeDown()
    {
        echo "m170511_063435_add_colum_in_covers cannot be reverted.\n";

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

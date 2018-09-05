<?php

use yii\db\Migration;

class m170515_073937_edit_colum_user_id_in_carts extends Migration
{
    public function up()
    {
        $this->dropForeignKey('carts_ibfk_5','carts');
        $this->alterColumn('carts','user_id',$this->string()->notNull());
        $this->renameColumn('carts','user_id','user_hash');
    }

    public function down()
    {
        echo "m170515_073937_edit_colum_user_id_in_carts cannot be reverted.\n";

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

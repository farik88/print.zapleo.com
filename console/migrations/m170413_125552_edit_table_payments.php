<?php

use yii\db\Migration;

class m170413_125552_edit_table_payments extends Migration
{
    public function safeUp()
    {
        $this->addColumn('payments','active',$this->integer()->defaultValue('0'));
        $this->addColumn('payments','comment',$this->text());
        $this->addColumn('payments','file_id',$this->integer()->notNull());

        $this->execute("ALTER TABLE `payments` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        $this->dropForeignKey('payments_ibfk_1','payments');
       $this->dropColumn('payments','active');
       $this->dropColumn('payments','comment');
       $this->dropColumn('payments','file_id');

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

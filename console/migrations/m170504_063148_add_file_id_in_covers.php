<?php

use yii\db\Migration;

class m170504_063148_add_file_id_in_covers extends Migration
{
    public function safeUp()
    {
        $this->addColumn('covers','file_id',$this->integer());
        $this->addColumn('covers','active', $this->integer()->defaultValue('1'));

        $this->execute("ALTER TABLE `covers` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }

    public function safeDown()
    {
        echo "m170504_063148_add_file_id_in_covers cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170302_124221_addColum_in_product_color extends Migration
{
    public function safeUp()
    {
        $this->execute('ALTER TABLE `product_color` ADD FOREIGN KEY (file_id) REFERENCES `files` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
    }

    public function safeDown()
    {
        echo "m170302_124221_addColum_in_product_color cannot be reverted.\n";

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

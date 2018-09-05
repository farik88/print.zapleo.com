<?php

use yii\db\Migration;

class m170224_083659_work_with_covers_and_sales extends Migration
{
    public function safeUp()
    {
        $this->dropForeignKey('covers_ibfk_1','covers');

        $this->dropColumn('covers','sale_id');

        $this->createTable('cover_sale', [
            'id' => $this->primaryKey(),
            'sale_id' => $this->integer()->notNull(),
            'cover_id' => $this->integer()->notNull(),
        ]);

        $this->execute('ALTER TABLE `cover_sale` ADD FOREIGN KEY (sale_id) REFERENCES `sales` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE `cover_sale` ADD FOREIGN KEY (cover_id) REFERENCES `covers` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
    }

    public function safeDown()
    {
        echo "m170224_083659_work_with_covers_and_sales cannot be reverted.\n";

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

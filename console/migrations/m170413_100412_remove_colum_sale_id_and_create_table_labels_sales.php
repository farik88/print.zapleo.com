<?php

use yii\db\Migration;

class m170413_100412_remove_colum_sale_id_and_create_table_labels_sales extends Migration
{
    public function up()
    {
        $this->dropForeignKey('labels_ibfk_1','labels');
        $this->dropColumn('labels','sale_id');

        $this->createTable('label_sale', [
            'id' => $this->primaryKey(),
            'label_id' => $this->integer()->notNull(),
            'sale_id' => $this->integer()->notNull(),
        ]);

        $this->execute("
ALTER TABLE `label_sale` ADD FOREIGN KEY (label_id) REFERENCES `labels` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE `label_sale` ADD FOREIGN KEY (sale_id) REFERENCES `sales` (`id`) ON UPDATE CASCADE ON DELETE RESTRICT;
");
    }

    public function down()
    {
        echo "m170413_100412_remove_colum_sale_id_and_create_table_labels_sales cannot be reverted.\n";

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

<?php

use yii\db\Migration;

class m170420_082833_create_access_admin extends Migration
{
    public function up()
    {
        $this->execute("INSERT INTO `accesses` (`id`, `title`, `value`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES (NULL, 'Admin', '30', '1111', '1111', '1', '1');
INSERT INTO `access_user` (`id`, `access_id`, `user_id`) VALUES (NULL, '1', '2');");
    }

    public function down()
    {
        echo "m170420_082833_create_access_admin cannot be reverted.\n";

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

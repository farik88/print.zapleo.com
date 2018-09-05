<?php

use yii\db\Migration;

class m180117_110355_update_source_message_table extends Migration
{
    public function up()
    {
        $this->addColumn('source_message', 'owner_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('source_message', 'owner_id');
    }

}

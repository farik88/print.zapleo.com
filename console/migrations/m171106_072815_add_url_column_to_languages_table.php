<?php

use yii\db\Migration;

/**
 * Handles adding url to table `languages`.
 */
class m171106_072815_add_url_column_to_languages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('languages', 'url', 'string');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('languages', 'url');
    }
}

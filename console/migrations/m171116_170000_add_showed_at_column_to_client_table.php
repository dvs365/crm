<?php

use yii\db\Migration;

class m171116_170000_add_showed_at_column_to_client_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%client}}', 'showed_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%client}}', 'showed_at');
    }
}

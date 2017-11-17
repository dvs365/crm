<?php

use yii\db\Migration;

class m171116_172000_add_showed_at_column_to_client_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('client_copy', 'showed_at', 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('client_copy', 'showed_at');
    }
}

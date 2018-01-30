<?php

use yii\db\Migration;

class m171206_100000_add_created_at_column_to_client_reject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%client_reject}}', 'created_at', $this->timestamp());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%client_reject}}', 'created_at');
    }
}

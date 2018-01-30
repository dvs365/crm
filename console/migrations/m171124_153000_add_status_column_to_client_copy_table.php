<?php

use yii\db\Migration;

class m171124_153000_add_status_column_to_client_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%client_copy}}', 'status', $this->integer()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%client_copy}}', 'status');
    }
}

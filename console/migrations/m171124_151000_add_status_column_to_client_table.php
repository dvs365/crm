<?php

use yii\db\Migration;

class m171124_151000_add_status_column_to_client_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%client}}', 'status', $this->integer()->notNull());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%client}}', 'status');
    }
}

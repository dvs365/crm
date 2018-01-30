<?php

use yii\db\Migration;

class m171128_131500_alter_status_column_to_client_copy_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('{{%client_copy}}', 'status', $this->smallInteger(6));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('{{%client_copy}}', 'status', $this->integer()->notNull());
    }
}
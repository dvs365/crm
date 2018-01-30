<?php

use yii\db\Migration;

class m171128_131000_alter_status_column_to_client_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('{{%client}}', 'status', $this->smallInteger(6));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('{{%client}}', 'status', $this->integer()->notNull());
    }
}
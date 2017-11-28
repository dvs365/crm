<?php

use yii\db\Migration;

class m171128_150000_alter_phone_column_to_client_phone_copy_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('client_phone_copy', 'phone', $this->string(255)->null()->unique());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('client_phone_copy', 'phone', $this->string(255)->notNull());
    }
}

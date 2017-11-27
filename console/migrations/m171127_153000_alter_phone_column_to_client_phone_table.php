<?php

use yii\db\Migration;

class m171127_153000_alter_phone_column_to_client_phone_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        //$this->update('client_phone', ['phone' => NULL], 'phone = ""');
        $this->alterColumn('client_phone', 'phone', $this->string(255)->null()->unique());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->update('client_phone', 'phone', 'phone = NULL', ['NULL' => '']);
        $this->alterColumn('client_phone', 'phone', $this->string(255)->notNull());
    }
}

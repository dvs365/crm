<?php

use yii\db\Migration;

class m171127_170000_alter_phone_column_to_client_contact_phone_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('client_contact_phone', 'phone', $this->string(255)->null()->unique());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->alterColumn('client_contact_phone', 'phone', $this->string(255)->notNull());
    }
}

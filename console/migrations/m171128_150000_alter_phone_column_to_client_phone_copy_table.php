<?php

use yii\db\Migration;

class m171128_150000_alter_phone_column_to_client_phone_copy_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('{{%client_phone_copy}}', 'phone', $this->string(255));
        $this->alterColumn('{{%client_phone_copy}}', 'phone', 'DROP NOT NULL');
        $this->alterColumn('{{%client_phone_copy}}', 'phone', 'SET DEFAULT NULL');
        $this->createIndex(
            'idx-client_phone_copy-phone',
            '{{%client_phone_copy}}',
            'phone',
            true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex(
            'idx-client_phone_copy-phone',
            '{{%client_phone_copy}}'
        );
        $this->update('{{%client_phone_copy}}', 'phone', 'phone = NULL', ['NULL' => '']);
        $this->alterColumn('{{%client_phone_copy}}', 'phone', $this->string(255));
        $this->alterColumn('{{%client_phone_copy}}', 'phone', 'DROP NULL');
        $this->alterColumn('{{%client_phone_copy}}', 'phone', 'SET DEFAULT NOT NULL');
    }
}

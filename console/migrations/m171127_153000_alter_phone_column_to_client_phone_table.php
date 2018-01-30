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
        $this->alterColumn('{{%client_phone}}', 'phone', $this->string(255));
        $this->alterColumn('{{%client_phone}}', 'phone', 'DROP NOT NULL');
        $this->alterColumn('{{%client_phone}}', 'phone', 'SET DEFAULT NULL');
        $this->createIndex(
            'idx-client_phone-phone',
            '{{%client_phone}}',
            'phone',
            true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops index for column `phone`
        $this->dropIndex(
            'idx-client_phone-phone',
            '{{%client_phone}}'
        );
        $this->update('{{%client_phone}}', 'phone', 'phone = NULL', ['NULL' => '']);
        $this->alterColumn('{{%client_phone}}', 'phone', $this->string(255));
        $this->alterColumn('{{%client_phone}}', 'phone', 'DROP NULL');
        $this->alterColumn('{{%client_phone}}', 'phone', 'SET DEFAULT NOT NULL');
    }
}

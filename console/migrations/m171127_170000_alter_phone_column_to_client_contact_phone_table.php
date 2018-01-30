<?php

use yii\db\Migration;

class m171127_170000_alter_phone_column_to_client_contact_phone_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('{{%client_contact_phone}}', 'phone', $this->string(255));
        $this->alterColumn('{{%client_contact_phone}}', 'phone', 'DROP NOT NULL');
        $this->alterColumn('{{%client_contact_phone}}', 'phone', 'SET DEFAULT NULL');
        $this->createIndex(
            'idx-phone_contact_phone-phone',
            '{{%client_contact_phone}}',
            'phone',
            true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops index for column `id`
        $this->dropIndex(
            'idx-phone_contact_phone-phone',
            '{{%client_contact_phone}}'
        );
        $this->alterColumn('{{%client_contact_phone}}', 'phone', $this->string(255));
        $this->alterColumn('{{%client_contact_phone}}', 'phone', 'DROP NULL');
        $this->alterColumn('{{%client_contact_phone}}', 'phone', 'SET DEFAULT NOT NULL');
    }
}

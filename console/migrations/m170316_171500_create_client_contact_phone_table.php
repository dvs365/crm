<?php

use yii\db\Migration;

class m170316_171500_create_client_contact_phone_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_contact_phone', [
            'id' => $this->primaryKey(),
            'contact_id' => $this->integer()->notNull(),
            'phone' => $this->string(255)->notNull(),
            'country' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'number' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_contact_phone`
        $this->createIndex(
            'idx-client_contact_phone-id',
            'client_contact_phone',
            'id'
        );

        // creates index for column `contact_id` in table `client_contact_phone`
        $this->createIndex(
            'idx-client_contact_phone-contact_id',
            'client_contact_phone',
            'contact_id'
        );

        // add foreign key for table `client_contact`
        $this->addForeignKey(
            'fk-client_contact_phone-contact_id',
            'client_contact_phone',
            'contact_id',
            'client_contact',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `client_contact`
        $this->dropForeignKey(
            'fk-client_contact_phone-contact_id',
            'client_contact_phone'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_contact_phone-id',
            'client_contact_phone'
        );

        // drops index for column `contact_phone_id`
        $this->dropIndex(
            'idx-client_contact_phone-contact_id',
            'client_contact_phone'
        );

        // drops table `client_contact_phone`
        $this->dropTable('client_contact_phone');
    }
}
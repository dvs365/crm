<?php

use yii\db\Migration;

class m170815_121500_create_client_contact_phone_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_contact_phone_copy', [
            'id' => $this->integer()->notNull()->unique(),
            'contact_id' => $this->integer()->notNull(),
            'phone' => $this->string(255)->notNull(),
            'country' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'number' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_contact_phone_copy`
        $this->createIndex(
            'idx-client_contact_phone_copy-id',
            'client_contact_phone_copy',
            'id'
        );

        // creates index for column `contact_id` in table `client_contact_phone_copy`
        $this->createIndex(
            'idx-client_contact_phone_copy-contact_id',
            'client_contact_phone_copy',
            'contact_id'
        );

        // add foreign key for table `client_contact_copy`
        $this->addForeignKey(
            'fk-client_contact_phone_copy-contact_id',
            'client_contact_phone_copy',
            'contact_id',
            'client_contact_copy',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `client_contact_copy`
        $this->dropForeignKey(
            'fk-client_contact_phone_copy-contact_id',
            'client_contact_phone_copy'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_contact_phone_copy-id',
            'client_contact_phone_copy'
        );

        // drops index for column `contact_phone_id`
        $this->dropIndex(
            'idx-client_contact_phone_copy-contact_id',
            'client_contact_phone_copy'
        );

        // drops table `client_contact_phone_copy`
        $this->dropTable('client_contact_phone_copy');
    }
}

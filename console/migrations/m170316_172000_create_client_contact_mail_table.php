<?php

use yii\db\Migration;

class m170316_172000_create_client_contact_mail_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_contact_mail', [
            'id' => $this->primaryKey(),
            'contact_id' => $this->integer()->notNull(),
            'address' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_contact_mail_copy`
        $this->createIndex(
            'idx-client_contact_mail-id',
            'client_contact_mail',
            'id'
        );

        // creates index for column `contact_id` in table `client_contact_mail`
        $this->createIndex(
            'idx-client_contact_mail-contact_id',
            'client_contact_mail',
            'contact_id'
        );

        // add foreign key for table `client_contact`
        $this->addForeignKey(
            'fk-client_contact_mail-contact_id',
            'client_contact_mail',
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
            'fk-client_contact_mail-contact_id',
            'client_contact_mail'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_contact_mail-id',
            'client_contact_mail'
        );

        // drops index for column `contact_id`
        $this->dropIndex(
            'idx-client_contact_mail-contact_id',
            'client_contact_mail'
        );

        // drops table `client_contact_mail`
        $this->dropTable('client_contact_mail');
    }
}

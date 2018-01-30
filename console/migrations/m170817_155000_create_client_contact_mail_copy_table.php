<?php

use yii\db\Migration;

class m170817_155000_create_client_contact_mail_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%client_contact_mail_copy}}', [
            'id' => $this->integer()->notNull()->unique(),
            'contact_id' => $this->integer()->notNull(),
            'address' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ], $tableOptions);

        // creates index for column `id` in table `client_contact_mail_copy`
        $this->createIndex(
            'idx-client_contact_mail_copy-id',
            '{{%client_contact_mail_copy}}',
            'id'
        );

        // creates index for column `contact_id` in table `client_contact_mail_copy`
        $this->createIndex(
            'idx-client_contact_mail_copy-contact_id',
            '{{%client_contact_mail_copy}}',
            'contact_id'
        );

        // add foreign key for table `client_contact_copy`
        $this->addForeignKey(
            'fk-client_contact_mail_copy-contact_id',
            '{{%client_contact_mail_copy}}',
            'contact_id',
            '{{%client_contact_copy}}',
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
            'fk-client_contact_mail_copy-contact_id',
            '{{%client_contact_mail_copy}}'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_contact_mail_copy-id',
            '{{%client_contact_mail_copy}}'
        );

        // drops index for column `contact_id`
        $this->dropIndex(
            'idx-client_contact_mail_copy-contact_id',
            '{{%client_contact_mail_copy}}'
        );

        // drops table `client_contact_mail_copy`
        $this->dropTable('{{%client_contact_mail_copy}}');
    }
}

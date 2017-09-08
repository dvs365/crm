<?php

use yii\db\Migration;

class m170814_151500_create_client_mail_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_mail_copy', [
            'id' => $this->integer()->notNull()->unique(),
            'client_id' => $this->integer()->notNull(),
            'address' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_mail_copy`
        $this->createIndex(
            'idx-client_mail_copy-id',
            'client_mail_copy',
            'id'
        );

        // creates index for column `client_id` in table `client_mail_copy`
        $this->createIndex(
            'idx-client_mail_copy-client_id',
            'client_mail_copy',
            'client_id'
        );

        // add foreign key for table `client_copy`
        $this->addForeignKey(
            'fk-client_mail_copy-client_id',
            'client_mail_copy',
            'client_id',
            'client_copy',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `client_copy`
        $this->dropForeignKey(
            'fk-client_mail_copy-client_id',
            'client_mail_copy'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_mail_copy-id',
            'client_mail_copy'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_mail_copy-client_id',
            'client_mail_copy'
        );

        // drops table `client_mail_copy`
        $this->dropTable('client_mail_copy');
    }
}

<?php

use yii\db\Migration;

class m170814_154500_create_client_contact_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_contact_copy', [
            'id' => $this->integer()->notNull()->unique(),
            'client_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'main' => 'ENUM("0", "1") NOT NULL',
            'position' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_contact_copy`
        $this->createIndex(
            'idx-client_contact_copy-id',
            'client_contact_copy',
            'id'
        );

        // creates index for column `client_id` in table `client_contact_copy`
        $this->createIndex(
            'idx-client_contact_copy-client_id',
            'client_contact_copy',
            'client_id'
        );

        // add foreign key for table `client_copy`
        $this->addForeignKey(
            'fk-client_contact_copy-client_id',
            'client_contact_copy',
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
            'fk-client_contact_copy-client_id',
            'client_contact_copy'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_contact_copy-id',
            'client_contact_copy'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_contact_copy-client_id',
            'client_contact_copy'
        );

        // drops table `client_contact_copy`
        $this->dropTable('client_contact_copy');
    }
}

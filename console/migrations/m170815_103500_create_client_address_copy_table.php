<?php

use yii\db\Migration;

class m170815_103500_create_client_address_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_address_copy', [
            'id' => $this->integer()->notNull()->unique(),
            'client_id' => $this->integer()->notNull(),
            'country' => $this->string(255)->notNull(),
            'region' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'street' => $this->string(255)->notNull(),
            'home' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
            'note' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_address_copy`
        $this->createIndex(
            'idx-client_address_copy-id',
            'client_address_copy',
            'id'
        );

        // creates index for column `client_id` in table `client_address_copy`
        $this->createIndex(
            'idx-client_address_copy-client_id',
            'client_address_copy',
            'client_id'
        );

        // add foreign key for table `client_copy`
        $this->addForeignKey(
            'fk-client_address_copy-client_id',
            'client_address_copy',
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
            'fk-client_address_copy-client_id',
            'client_address_copy'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_address_copy-id',
            'client_address_copy'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_address_copy-client_id',
            'client_address_copy'
        );

        // drops table `client_address_copy`
        $this->dropTable('client_address_copy');
    }
}

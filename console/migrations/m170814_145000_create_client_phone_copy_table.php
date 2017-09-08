<?php

use yii\db\Migration;

class m170814_145000_create_client_phone_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_phone_copy', [
            'id' => $this->integer()->notNull()->unique(),
            'client_id' => $this->integer()->notNull(),
            'phone' => $this->string(255)->notNull(),
            'country' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'number' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_phone_copy`
        $this->createIndex(
            'idx-client_phone_copy-id',
            'client_phone_copy',
            'id'
        );

        // creates index for column `client_id` in table `client_phone_copy`
        $this->createIndex(
            'idx-client_phone_copy-client_id',
            'client_phone_copy',
            'client_id'
        );

        // add foreign key for table `client_copy`
        $this->addForeignKey(
            'fk-client_phone_copy-client_id',
            'client_phone_copy',
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
            'fk-client_phone_copy-client_id',
            'client_phone_copy'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_phone_copy-id',
            'client_phone_copy'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_phone_copy-client_id',
            'client_phone_copy'
        );

        // drops table `client_phone_copy`
        $this->dropTable('client_phone_copy');
    }
}

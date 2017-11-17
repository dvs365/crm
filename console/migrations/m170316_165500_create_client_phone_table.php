<?php

use yii\db\Migration;

class m170316_165500_create_client_phone_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_phone', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'phone' => $this->string(255)->notNull(),
            'country' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'number' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ]);

        // creates index for column `id` in table `client_phone_copy`
        $this->createIndex(
            'idx-client_phone-id',
            'client_phone',
            'id'
        );

        // creates index for column `client_id` in table `client_phone_copy`
        $this->createIndex(
            'idx-client_phone-client_id',
            'client_phone',
            'client_id'
        );

        // add foreign key for table `client_copy`
        $this->addForeignKey(
            'fk-client_phone-client_id',
            'client_phone',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `client`
        $this->dropForeignKey(
            'fk-client_phone-client_id',
            'client_phone'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_phone-id',
            'client_phone'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_phone-client_id',
            'client_phone'
        );

        // drops table `client_phone`
        $this->dropTable('client_phone');
    }
}

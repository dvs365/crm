<?php

use yii\db\Migration;

class m170316_164000_create_client_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'user_add_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'anchor' => 'ENUM("0", "1") NOT NULL',
            'update' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // creates index for column `id` in table `client_jur`
        $this->createIndex(
            'idx-client-user_id',
            'client',
            'user_id'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-client-id',
            'client_copy',
            'id',
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

        // drops index for column `id`
        $this->dropIndex(
            'idx-client-id',
            'client'
        );

        // drops table `client_copy`
        $this->dropTable('client');
    }
}

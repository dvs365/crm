<?php

use yii\db\Migration;

class m170809_144000_create_client_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_copy', [
            'id' => $this->integer()->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
            'user_add_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'anchor' => 'ENUM("0", "1") NOT NULL',
            'update' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ]);

        // creates index for column `id` in table `client_copy`
        $this->createIndex(
            'idx-client_copy-id',
            'client_copy',
            'id'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-client_copy-id',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-client_copy-id',
            'client_copy'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_copy-id',
            'client_copy'
        );

        // drops table `client_copy`
        $this->dropTable('client_copy');
    }
}

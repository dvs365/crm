<?php

use yii\db\Migration;

class m170811_163000_create_client_jur_copy_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_jur_copy', [
            'id' => $this->integer()->notNull()->unique(),
            'client_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
        ]);

        // creates index for column `id` in table `client_jur_copy`
        $this->createIndex(
            'idx-client_jur_copy-id',
            'client_jur_copy',
            'id'
        );

        // creates index for column `client_id` in table `client_jur_copy`
        $this->createIndex(
            'idx-client_jur_copy-client_id',
            'client_jur_copy',
            'client_id'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-client_jur_copy-client_id',
            'client_jur_copy',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-client_jur_copy-client_id',
            'client_jur_copy'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_jur_copy-id',
            'client_jur_copy'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_jur_copy-client_id',
            'client_jur_copy'
        );

        // drops table `client_jur_copy`
        $this->dropTable('client_jur_copy');
    }
}

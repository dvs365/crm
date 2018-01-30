<?php

use yii\db\Migration;

class m170316_171000_create_client_address_table extends Migration
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
        $this->createTable('{{%client_address}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'country' => $this->string(255)->notNull(),
            'region' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'street' => $this->string(255)->notNull(),
            'home' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
            'note' => $this->string(255)->notNull(),
        ], $tableOptions);

        // creates index for column `id` in table `client_address`
        $this->createIndex(
            'idx-client_address-id',
            '{{%client_address}}',
            'id'
        );

        // creates index for column `client_id` in table `client_address`
        $this->createIndex(
            'idx-client_address-client_id',
            '{{%client_address}}',
            'client_id'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-client_address-client_id',
            '{{%client_address}}',
            'client_id',
            '{{%client}}',
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
            'fk-client_address-client_id',
            '{{%client_address}}'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_address-id',
            '{{%client_address}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_address-client_id',
            '{{%client_address}}'
        );

        // drops table `client_address`
        $this->dropTable('{{%client_address}}');
    }
}

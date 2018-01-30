<?php

use yii\db\Migration;

class m170316_165500_create_client_phone_table extends Migration
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
        $this->createTable('{{%client_phone}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'phone' => $this->string(255)->notNull(),
            'country' => $this->string(255)->notNull(),
            'city' => $this->string(255)->notNull(),
            'number' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ], $tableOptions);

        // creates index for column `id` in table `client_phone_copy`
        $this->createIndex(
            'idx-client_phone-id',
            '{{%client_phone}}',
            'id'
        );

        // creates index for column `client_id` in table `client_phone_copy`
        $this->createIndex(
            'idx-client_phone-client_id',
            '{{%client_phone}}',
            'client_id'
        );

        // add foreign key for table `client_copy`
        $this->addForeignKey(
            'fk-client_phone-client_id',
            '{{%client_phone}}',
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
            'fk-client_phone-client_id',
            '{{%client_phone}}'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_phone-id',
            '{{%client_phone}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_phone-client_id',
            '{{%clientPhone}}'
        );

        // drops table `client_phone`
        $this->dropTable('{{%clientPhone}}');
    }
}

<?php

use yii\db\Migration;

class m170316_170000_create_client_mail_table extends Migration
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
        $this->createTable('{{%client_mail}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'address' => $this->string(255)->notNull(),
            'comment' => $this->string(255)->notNull(),
        ], $tableOptions);

        // creates index for column `id` in table `client_mail`
        $this->createIndex(
            'idx-client_mail-id',
            '{{%client_mail}}',
            'id'
        );

        // creates index for column `client_id` in table `client_mail_copy`
        $this->createIndex(
            'idx-client_mail-client_id',
            '{{%client_mail}}',
            'client_id'
        );

        // add foreign key for table `client_copy`
        $this->addForeignKey(
            'fk-client_mail-client_id',
            '{{%client_mail}}',
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
            'fk-client_mail-client_id',
            '{{%client_mail}}'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_mail-id',
            '{{%client_mail}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_mail-client_id',
            '{{%client_mail}}'
        );

        // drops table `client_mail`
        $this->dropTable('{{%client_mail}}');
    }
}

<?php

use yii\db\Migration;

class m170809_144000_create_client_copy_table extends Migration
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
        $this->createTable('{{%client_copy}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'user_add_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'anchor' => $this->smallInteger(6),
            'update' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        // creates index for column `id` in table `client_copy`
        $this->createIndex(
            'idx-client_copy-id',
            '{{%client_copy}}',
            'id'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-client_copy-id',
            '{{%client_copy}}',
            'id',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-client_copy-id',
            '{{%client_copy}}'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_copy-id',
            '{{%client_copy}}'
        );

        // drops table `client_copy`
        $this->dropTable('{{%client_copy}}');
    }
}

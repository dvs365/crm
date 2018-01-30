<?php

use yii\db\Migration;

class m170316_164000_create_client_table extends Migration
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
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'user_add_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
            'anchor' => $this->smallInteger(6),
            'update' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        // creates index for column `id` in table `client_jur`
        $this->createIndex(
            'idx-client-user_id',
            '{{%client}}',
            'user_id'
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
            '{{%client}}'
        );
        // drops index for column `user_id`
        $this->dropIndex(
            'idx-client-user_id',
            '{{%client}}'
        );
        // drops table `client`
        $this->dropTable('{{%client}}');
    }
}

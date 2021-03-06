<?php

use yii\db\Migration;

class m170316_165000_create_client_jur_table extends Migration
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
        $this->createTable('{{%client_jur}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()->defaultValue(''),
        ], $tableOptions);

        // creates index for column `id` in table `client_jur`
        $this->createIndex(
            'idx-client_jur-id',
            '{{%client_jur}}',
            'id'
        );

        // creates index for column `client_id` in table `client_jur`
        $this->createIndex(
            'idx-client_jur-client_id',
            '{{%client_jur}}',
            'client_id'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-client_jur-client_id',
            '{{%client_jur}}',
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
            'fk-client_jur-client_id',
            '{{%client_jur}}'
        );

        // drops index for column `id`
        $this->dropIndex(
            'idx-client_jur-id',
            '{{%client_jur}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            'idx-client_jur-client_id',
            '{{%client_jur}}'
        );

        // drops table `client_jur`
        $this->dropTable('{{%client_jur}}');
    }
}
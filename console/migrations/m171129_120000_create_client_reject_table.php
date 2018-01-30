<?php

use yii\db\Migration;

class m171129_120000_create_client_reject_table extends Migration
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
        $this->createTable('{{%client_reject}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'reason' => $this->string(255)->notNull()->defaultValue(''),
        ], $tableOptions);

        // add foreign key for table `client_reject`
        $this->addForeignKey(
            'fk-client_reject-client_id',
            '{{%client_reject}}',
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
        // drops foreign key for table `client_reject`
        $this->dropForeignKey(
            'fk-client_reject-client_id',
            '{{%client_reject}}'
        );

        // drops table `client_copy`
        $this->dropTable('{{%client_reject}}');
    }
}

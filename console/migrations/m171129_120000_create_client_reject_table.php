<?php

use yii\db\Migration;

class m171129_120000_create_client_reject_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('client_reject', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'reason' => $this->string(255)->notNull()->defaultValue(''),
        ]);

        // add foreign key for table `client_reject`
        $this->addForeignKey(
            'fk-client_reject-client_id',
            'client_reject',
            'client_id',
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
        // drops foreign key for table `client_reject`
        $this->dropForeignKey(
            'fk-client_reject-client_id',
            'client_reject'
        );

        // drops table `client_copy`
        $this->dropTable('client_reject');
    }
}

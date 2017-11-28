<?php

use yii\db\Migration;

class m171127_180000_alter_user_id_column_to_client_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->dropForeignKey('client_ibfk_1', 'client');
        $this->alterColumn('client', 'user_id', $this->integer()->null());
        $this->addForeignKey(
            'fk-client-user_id',
            'client',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-client-user_id', 'client');
        $this->alterColumn('client', 'user_id', $this->integer()->notNull());
        $this->addForeignKey(
            'fk-client-user_id',
            'client',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }
}

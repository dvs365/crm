<?php

use yii\db\Migration;

class m171130_153000_alter_user_id_column_to_client_copy_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->dropForeignKey('fk-client-id', 'client_copy');
        $this->alterColumn('client_copy', 'user_id', $this->integer()->null());
        $this->addForeignKey(
            'fk-client_copy-user_id',
            'client_copy',
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
        $this->dropForeignKey('fk-client_copy-user_id', 'client_copy');
        $this->alterColumn('client_copy', 'user_id', $this->integer()->notNull());
        $this->addForeignKey(
            'fk-client-id',
            'client_copy',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }
}

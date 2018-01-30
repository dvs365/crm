<?php

use yii\db\Migration;

class m171130_153000_alter_user_id_column_to_client_copy_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('{{%client_copy}}', 'user_id', $this->integer());
        $this->alterColumn('{{%client_copy}}', 'user_id', 'DROP NOT NULL');
        $this->alterColumn('{{%client_copy}}', 'user_id', 'SET DEFAULT NULL');
        $this->addForeignKey(
            'fk-client_copy-user_id',
            '{{%client_copy}}',
            'user_id',
            '{{%user}}',
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
        $this->update('{{%client_copy}}', 'user_id', 'user_id = NULL', ['NULL' => '']);
        $this->alterColumn('{{%client_copy}}', 'user_id', $this->integer());
        $this->alterColumn('{{%client_copy}}', 'user_id', 'DROP NULL');
        $this->alterColumn('{{%client_copy}}', 'user_id', 'SET DEFAULT NOT NULL');
    }
}

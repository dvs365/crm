<?php

use yii\db\Migration;

class m171127_180000_alter_user_id_column_to_client_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->alterColumn('{{%client}}', 'user_id', $this->integer());
        $this->alterColumn('{{%client}}', 'user_id', 'DROP NOT NULL');
        $this->alterColumn('{{%client}}', 'user_id', 'SET DEFAULT NULL');
        $this->addForeignKey(
            'fk-client-user_id',
            '{{%client}}',
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
        $this->dropForeignKey('fk-client-user_id', '{{%client}}');
        $this->alterColumn('{{%client}}', 'user_id', $this->integer());
        $this->alterColumn('{{%client}}', 'user_id', 'DROP NULL');
        $this->alterColumn('{{%client}}', 'user_id', 'SET DEFAULT NOT NULL');
        $this->addForeignKey(
            'fk-client-user_id',
            '{{%client}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }
}

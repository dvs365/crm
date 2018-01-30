<?php

use yii\db\Migration;

class m180125_173000_create_todo_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%todo}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'desc' => $this->string()->notNull(),
            'time_from' => $this->dateTime()->notNull(),
            'time_to' => $this->dateTime()->null(),
            'repeat' => $this->smallInteger(2)->notNull()->defaultValue(0),
        ], $tableOptions);

        // creates index for column `id` in table `todo`
        $this->createIndex(
            'idx-todo-client_id',
            '{{%todo}}',
            'client_id'
        );
    }

    public function down()
    {
        $this->dropTable('{{%todo}}');
    }
}
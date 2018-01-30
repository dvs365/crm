<?php

use yii\db\Migration;

class m170619_115500_create_delivery_table extends Migration
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
		$this->createTable('{{%delivery}}', [
			'id' => $this->primaryKey(),
			'bill_id' => $this->integer(),
		], $tableOptions);
	}

	/**
	 * @inheritdoc
	 */
	public function down()
	{
		$this->dropTable('{{%delivery}}');
	}
}

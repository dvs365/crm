<?php

use yii\db\Migration;

class m170619_115500_create_delivery_table extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function up()
	{
		$this->createTable('delivery', [
			'id' => $this->primaryKey(),
			'bill_id' => $this->integer(),
		]);
	}

	/**
	 * @inheritdoc
	 */
	public function down()
	{
		$this->dropTable('delivery');
	}
}

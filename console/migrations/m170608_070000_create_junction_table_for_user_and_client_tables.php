<?php

/**
 * Created by IntelliJ IDEA.
 * User: dvs
 * Date: 08.06.17
 * Time: 10:19
 */
use yii\db\Migration;

class m170608_create_junction_table_for_user_and_client_tables extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function up()
	{
		$this->createTable('user_client', [
			'user_id' => $this->integer(),
			'client_id' => $this->integer(),
			'PRIMARY KEY(user_id, client_id)',
		]);

		// creates index for column `user_id`
		$this->createIndex(
			'idx-user_client-user_id',
			'user_client',
			'user_id'
		);

		// add foreign key for table `user`
		$this->addForeignKey(
			'fk-user_client-user_id',
			'user_client',
			'user_id',
			'user',
			'id',
			'CASCADE'
		);

		// creates index for column `client_id`
		$this->createIndex(
			'idx-user_client-client_id',
			'user_client',
			'client_id'
		);

		// add foreign key for table `client`
		$this->addForeignKey(
			'fk-user_client-client_id',
			'user_client',
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
		// drops foreign key for table `user`
		$this->dropForeignKey(
			'fk-user_client-user_id',
			'user_client'
		);

		// drops index for column `user_id`
		$this->dropIndex(
			'idx-user_client-user_id',
			'user_client'
		);

		// drops foreign key for table `client`
		$this->dropForeignKey(
			'fk-user_client-client_id',
			'user_client'
		);

		// drops index for column `client_id`
		$this->dropIndex(
			'idx-user_client-client_id',
			'user_client'
		);

		$this->dropTable('user_client');
	}
}
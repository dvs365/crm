<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_contact".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 * @property string $main
 * @property string $position
 *
 * @property Client $client
 */
class ClientContact extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'client_contact';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['client_id'], 'integer'],
			[['main'], 'string'],
			[['name', 'position'], 'string', 'max' => 255],
			[['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'client_id' => 'Client ID',
			'name' => 'ФИО',
			'main' => 'Основное контактное лицо',
			'position' => 'Должность',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClient()
	{
		return $this->hasOne(Client::className(), ['id' => 'client_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientContactPhones()
	{
		return $this->hasMany(ClientContactPhone::className(), ['contact_id' => 'id']);
	}
}
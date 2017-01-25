<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 *
 * @property User $user
 * @property ClientContact[] $clientContacts
 * @property ClientJur[] $clientJurs
 * @property ClientMail[] $clientMails
 * @property ClientPhone[] $clientPhones
 */
class Client extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'client';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'name'], 'required'],
			[['user_id'], 'integer'],
			[['user_add_id'], 'integer'],
			['user_add_id', 'default', 'value' => '0'],
			[['name'], 'string', 'max' => 255],
			[['anchor'], 'string'],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'Менеджер',
			'user_add_id' => 'Дополнительный просмотр User ID',
			'name' => 'Условное название',
			'anchor' => 'Якорный клиент',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientContacts()
	{
		return $this->hasMany(ClientContact::className(), ['client_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientJurs()
	{
		return $this->hasMany(ClientJur::className(), ['client_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientMails()
	{
		return $this->hasMany(ClientMail::className(), ['client_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientPhones()
	{
		return $this->hasMany(ClientPhone::className(), ['client_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientAddresses()
	{
		return $this->hasMany(ClientAddress::className(), ['client_id' => 'id']);
	}
}
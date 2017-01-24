<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_contact_mail".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property string $address
 * @property string $comment
 *
 * @property ClientContact $contact
 */
class ClientContactMail extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'client_contact_mail';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['contact_id'], 'integer'],
			[['address', 'comment'], 'string', 'max' => 255],
			[['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientContact::className(), 'targetAttribute' => ['contact_id' => 'id']],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'contact_id' => 'Contact ID',
			'address' => 'E-mail',
			'comment' => 'Комментарий',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getContact()
	{
		return $this->hasOne(ClientContact::className(), ['id' => 'contact_id']);
	}
}
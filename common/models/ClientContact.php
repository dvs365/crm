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
     *
     */
    public static function loadMultipleCopy(array $contacts, array $contactsCopy): array
    {
        foreach ($contactsCopy as $indexContact => $contactCopy) {
            if (!isset($contacts[$indexContact])) {
                $contacts[$indexContact] = new ClientContact;
                $contacts[$indexContact]->id = $contactCopy->id;
            }
            $contacts[$indexContact]->client_id = $contactCopy->client_id;
            $contacts[$indexContact]->name = $contactCopy->name;
            $contacts[$indexContact]->main = $contactCopy->main;
            $contacts[$indexContact]->position = $contactCopy->position;
        }
        return $contacts;
    }
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

			[['main'], 'integer'],
            ['main', 'filter', 'filter' => 'intval'],

            [['name', 'position'], 'string', 'max' => 255],
            [['name'], 'trim'],

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
			'name' => 'Контактное лицо',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactPhonesID()
    {
        return $this->hasMany(ClientContactPhone::className(), ['contact_id' => 'id'])->indexBy('id');
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientContactMails()
	{
		return $this->hasMany(ClientContactMail::className(), ['contact_id' => 'id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactMailsID()
    {
        return $this->hasMany(ClientContactMail::className(), ['contact_id' => 'id'])->indexBy('id');
    }
}
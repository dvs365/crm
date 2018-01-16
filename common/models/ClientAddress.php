<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_address".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $street
 * @property string $home
 * @property string $comment
 * @property string $note
 *
 * @property Client $client
 */
class ClientAddress extends \yii\db\ActiveRecord
{
    /**
     *
     */
    public static function loadMultipleCopy(array $addresses, array $addressesCopy): array
    {
        foreach ($addressesCopy as $indexAddress => $addressCopy) {
            if (!isset($addresses[$indexAddress])) {
                $addresses[$indexAddress] = new ClientAddress;
                $addresses[$indexAddress]->id = $addressCopy->id;
            }
            $addresses[$indexAddress]->client_id = $addressCopy->client_id;
            $addresses[$indexAddress]->country = $addressCopy->country;
            $addresses[$indexAddress]->region = $addressCopy->region;
            $addresses[$indexAddress]->city = $addressCopy->city;
            $addresses[$indexAddress]->street = $addressCopy->street;
            $addresses[$indexAddress]->home = $addressCopy->home;
            $addresses[$indexAddress]->comment = $addressCopy->comment;
            $addresses[$indexAddress]->note = $addressCopy->note;
        }
        return $addresses;
    }
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'client_address';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['client_id'], 'integer'],

			[['country', 'region', 'city', 'street', 'home', 'comment', 'note'], 'string', 'max' => 255],
            [['country', 'region', 'city', 'street', 'home', 'comment', 'note'], 'trim'],

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
			'country' => 'Страна',
			'region' => 'Регион',
			'city' => 'Город',
			'street' => 'Улица',
			'home' => 'Дом/корпус/офис',
			'comment' => 'Комментарий',
			'note' => 'Записка суперпользователя',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClient()
	{
		return $this->hasOne(Client::className(), ['id' => 'client_id']);
	}
}
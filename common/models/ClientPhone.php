<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_phone".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $phone
 * @property string $country
 * @property string $city
 * @property string $number
 * @property string $comment
 *
 * @property Client $client
 */
class ClientPhone extends \yii\db\ActiveRecord
{
    /**
     *
     */
    public static function loadMultipleCopy(array $phones, array $phonesCopy): array
    {
        foreach ($phonesCopy as $indexPhone => $phoneCopy) {
            if (!isset($phones[$indexPhone])) {
                $phones[$indexPhone] = new ClientPhone;
                $phones[$indexPhone]->id = $phoneCopy->id;
            }
            $phones[$indexPhone]->client_id = $phoneCopy->client_id;
            $phones[$indexPhone]->phone = $phoneCopy->phone;
            $phones[$indexPhone]->country = $phoneCopy->country;
            $phones[$indexPhone]->city = $phoneCopy->city;
            $phones[$indexPhone]->number = $phoneCopy->number;
            $phones[$indexPhone]->comment = $phoneCopy->comment;
        }
        return $phones;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id'], 'integer'],
			['phone', 'default', 'value' => ''],
            [['phone', 'country', 'city', 'number', 'comment'], 'string', 'max' => 255],
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
            'phone' => 'Телефон',
            'country' => 'Страна',
            'city' => 'Город',
            'number' => 'Номер',
            'comment' => 'Комментарий',
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

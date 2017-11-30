<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_phone_copy".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $phone
 * @property string $country
 * @property string $city
 * @property string $number
 * @property string $comment
 *
 * @property ClientCopy $client
 */
class ClientPhoneCopy extends \yii\db\ActiveRecord
{
    public static function create(int $id, int $client_id, int $phone = null, string $country, string $city, string $number, string $comment): self
    {
        $clientPhoneCopy = new ClientPhoneCopy;
        $clientPhoneCopy->id = $id;
        $clientPhoneCopy->client_id = $client_id;
        $clientPhoneCopy->phone = $phone;
        $clientPhoneCopy->country = $country;
        $clientPhoneCopy->city = $city;
        $clientPhoneCopy->number = $number;
        $clientPhoneCopy->comment = $comment;
        return $clientPhoneCopy;
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_phone_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id'], 'required'],
            [['client_id'], 'integer'],
            [['phone', 'country', 'city', 'number', 'comment'], 'string', 'max' => 255],
            [['phone'], 'unique'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientCopy::className(), 'targetAttribute' => ['client_id' => 'id']],
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
            'country' => 'Country',
            'city' => 'City',
            'number' => 'Number',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(ClientCopy::className(), ['id' => 'client_id']);
    }
}
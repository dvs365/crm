<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_address_copy".
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
 * @property ClientCopy $client
 */
class ClientAddressCopy extends \yii\db\ActiveRecord
{
    public static function create(int $id, int $client_id, string $country, string $region, string $city, string $street, string $home, string $comment, string $note): self
    {
        $clientAddressCopy = new ClientAddressCopy;
        $clientAddressCopy->id = $id;
        $clientAddressCopy->client_id = $client_id;
        $clientAddressCopy->country = $country;
        $clientAddressCopy->region = $region;
        $clientAddressCopy->city = $city;
        $clientAddressCopy->street = $street;
        $clientAddressCopy->home = $home;
        $clientAddressCopy->comment = $comment;
        $clientAddressCopy->note = $note;
        return $clientAddressCopy;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_address_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id'], 'required'],
            [['client_id'], 'integer'],
            [['country', 'region', 'city', 'street', 'home', 'comment', 'note'], 'string', 'max' => 255],
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
            'country' => 'Country',
            'region' => 'Region',
            'city' => 'City',
            'street' => 'Street',
            'home' => 'Home',
            'comment' => 'Comment',
            'note' => 'Note',
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
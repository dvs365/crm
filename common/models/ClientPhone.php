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
            [['id', 'client_id', 'phone', 'country', 'city', 'number', 'comment'], 'required'],
            [['id', 'client_id', 'phone'], 'integer'],
            [['country', 'city', 'number', 'comment'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
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
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}

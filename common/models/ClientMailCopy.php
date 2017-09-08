<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_mail_copy".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $address
 * @property string $comment
 *
 * @property ClientCopy $client
 */
class ClientMailCopy extends \yii\db\ActiveRecord
{
    public static function create(int $id, int $client_id, string $address, string $comment): self
    {
        $clientMailCopy = new ClientMailCopy;
        $clientMailCopy->id = $id;
        $clientMailCopy->client_id = $client_id;
        $clientMailCopy->address = $address;
        $clientMailCopy->comment = $comment;
        return $clientMailCopy;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_mail_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id'], 'required'],
            [['client_id'], 'integer'],
            [['address', 'comment'], 'string', 'max' => 255],
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
            'address' => 'Address',
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
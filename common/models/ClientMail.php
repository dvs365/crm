<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_mail".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $address
 * @property string $comment
 *
 * @property Client $client
 */
class ClientMail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_mail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'address', 'comment'], 'required'],
            [['client_id'], 'integer'],
            [['address', 'comment'], 'string', 'max' => 255],
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
            'address' => 'Address',
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

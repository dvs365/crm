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
     *
     */
    public static function loadMultipleCopy(array $mails, array $mailsCopy): array
    {
        foreach ($mailsCopy as $indexMail => $mailCopy) {
            if (!isset($mails[$indexMail])) {
                $mails[$indexMail] = new ClientMail;
                $mails[$indexMail]->id = $mailCopy->id;
            }
            $mails[$indexMail]->client_id = $mailCopy->client_id;
            $mails[$indexMail]->address = $mailCopy->address;
            $mails[$indexMail]->comment = $mailCopy->comment;
        }
        return $mails;
    }
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
            [['client_id'], 'integer'],
			[['address'], 'email'],
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
            'address' => 'E-mail клиента',
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

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_contact_mail_copy".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property string $address
 * @property string $comment
 *
 * @property ClientContactCopy $contact
 */
class ClientContactMailCopy extends \yii\db\ActiveRecord
{
    public static function create(int $id, int $contact_id, string $address, string $comment): self
    {
        $clientContactMailCopy = new ClientContactMailCopy;
        $clientContactMailCopy->id = $id;
        $clientContactMailCopy->contact_id = $contact_id;
        $clientContactMailCopy->address = $address;
        $clientContactMailCopy->comment = $comment;
        return $clientContactMailCopy;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_contact_mail_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['contact_id'], 'integer'],
            [['address', 'comment'], 'string', 'max' => 255],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientContactCopy::className(), 'targetAttribute' => ['contact_id' => 'id']],
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
            'address' => 'Address',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(ClientContactCopy::className(), ['id' => 'contact_id']);
    }
}
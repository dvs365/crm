<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_contact_phone_copy".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property string $phone
 * @property string $country
 * @property string $city
 * @property string $number
 * @property string $comment
 *
 * @property ClientContactCopy $contact
 */
class ClientContactPhoneCopy extends \yii\db\ActiveRecord
{
    public static function create(int $id, int $contact_id, string $phone = null, string $country, string $city, string $number, string $comment): self
    {
        $clientContactPhoneCopy = new ClientContactPhoneCopy;
        $clientContactPhoneCopy->id = $id;
        $clientContactPhoneCopy->contact_id = $contact_id;
        $clientContactPhoneCopy->phone = $phone;
        $clientContactPhoneCopy->country = $country;
        $clientContactPhoneCopy->city = $city;
        $clientContactPhoneCopy->number = $number;
        $clientContactPhoneCopy->comment = $comment;
        return $clientContactPhoneCopy;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_contact_phone_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['contact_id'], 'integer'],
            [['phone', 'country', 'city', 'number', 'comment'], 'string', 'max' => 255],
            [['phone'], 'unique'],
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
    public function getContact()
    {
        return $this->hasOne(ClientContactCopy::className(), ['id' => 'contact_id']);
    }
}
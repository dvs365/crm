<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_contact_phone".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property integer $phone
 * @property string $country
 * @property string $city
 * @property string $number
 * @property string $comment
 *
 * @property ClientContact $contact
 */
class ClientContactPhone extends \yii\db\ActiveRecord
{
    /**
     *
     */
    public static function loadMultipleCopy(array $contactPhones, array $contactPhonesCopy): array
    {
        foreach ($contactPhonesCopy as $indexContactPhone => $contactPhoneCopy) {
            if (!isset($contactPhones[$indexContactPhone])) {
                $contactPhones[$indexContactPhone] = new ClientContactPhone;
                $contactPhones[$indexContactPhone]->id = $contactPhoneCopy->id;
            }
            $contactPhones[$indexContactPhone]->contact_id = $contactPhoneCopy->contact_id;
            $contactPhones[$indexContactPhone]->phone = $contactPhoneCopy->phone;
            $contactPhones[$indexContactPhone]->country = $contactPhoneCopy->country;
            $contactPhones[$indexContactPhone]->city = $contactPhoneCopy->city;
            $contactPhones[$indexContactPhone]->number = $contactPhoneCopy->number;
            $contactPhones[$indexContactPhone]->comment = $contactPhoneCopy->comment;
        }
        return $contactPhones;
    }
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'client_contact_phone';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['contact_id'], 'integer'],
			[['phone', 'country', 'city', 'number', 'comment'], 'string', 'max' => 255],
			['phone', 'default', 'value' => ''],
			[['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientContact::className(), 'targetAttribute' => ['contact_id' => 'id']],
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
			'country' => 'Страна',
			'city' => 'Город',
			'number' => 'Номер',
			'comment' => 'Комментарий',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getContact()
	{
		return $this->hasOne(ClientContact::className(), ['id' => 'contact_id']);
	}
}
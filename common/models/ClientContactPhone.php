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

    public $client_id;

    public static function create(int $id, string $phone = null, string $country, string $city, string $number, string $comment): self
    {
        $ClientContactPhone = new ClientContactPhone;
        $ClientContactPhone->id = $id;
        $ClientContactPhone->phone = $phone;
        $ClientContactPhone->country = $country;
        $ClientContactPhone->city = $city;
        $ClientContactPhone->number = $number;
        $ClientContactPhone->comment = $comment;
        return $ClientContactPhone;
    }
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
            ['phone', 'default', 'value' => null],
            [['phone'], 'unique'],
            [['phone'], 'match', 'pattern' => "/[0-9]{11}/"],

            [['comment'], 'string', 'max' => 255],
            [['comment'], 'trim'],

            ['country', 'match', 'pattern' => '/\+[7]$/'],
            ['city', 'match', 'pattern' => '/^[0-9]{3}$/'],
            ['number', 'match', 'pattern' => '/^[0-9]{3}-[0-9]{2}-[0-9]{2}$/'],

            [['country', 'city', 'number'], 'required', 'when' => function ($model) {
                return !empty($model->country) || !empty($model->city) || !empty($model->number) || !empty($model->comment);
            }, 'whenClient' => "function (attribute, value) {
                var parent = $('#' + $(attribute).prop('id')).closest('div.item_client_contact_phone');
                return parent.find('input[country]').val().length
                    || parent.find('input[city]').val().length
                    || parent.find('input[number]').val().length
                    || parent.find('input[phone-comment]').val().length;
            }"],

            [['contact_id'], 'integer'],
            [['number'], 'validateContactp'],

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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->phone = preg_replace("/[^0-9]/", '', $this->country.$this->city.$this->number) ?: null;
            return true;
        } else {
            return false;
        }
    }

    public function validateContactp($attribute, $params)
    {
        $fullphone = $this->country .' '. $this->city .' '. $this->number;
        $phoneQuery = ClientPhone::find()->where(['country' => $this->country, 'city' => $this->city, 'number' => $this->number]);
        $contactPhoneQuery = ClientContactPhone::find()->where(['country' => $this->country, 'city' => $this->city, 'number' => $this->number]);
        if (!empty($this->client_id)) {
            $phoneQuery->andWhere(['!=', 'client_id', $this->client_id]);
            $contactsID = array_column(ClientContact::find()->where(['client_id' => $this->client_id])->all(), 'id');
            $contactPhoneQuery->AndWhere(['not in', 'contact_id', $contactsID]);
        }
        $phone = $phoneQuery->one();
        $contactPhone = $contactPhoneQuery->one();

        if (!empty($phone) || !empty($contactPhone)) {
            $this->addError('country', 'Телефон ' . $fullphone . ' уже существует.');
            $this->addError('city', 'Телефон ' . $fullphone . ' уже существует.');
            $this->addError('number', 'Телефон ' . $fullphone . ' уже существует.');
        }
    }
}
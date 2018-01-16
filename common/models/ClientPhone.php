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
     *
     */
    public static function loadMultipleCopy(array $phones, array $phonesCopy): array
    {
        foreach ($phonesCopy as $indexPhone => $phoneCopy) {
            if (!isset($phones[$indexPhone])) {
                $phones[$indexPhone] = new ClientPhone;
                $phones[$indexPhone]->id = $phoneCopy->id;
            }
            $phones[$indexPhone]->client_id = $phoneCopy->client_id;
            $phones[$indexPhone]->phone = !empty($phoneCopy->phone) ? $phoneCopy->phone : null;
            $phones[$indexPhone]->country = $phoneCopy->country;
            $phones[$indexPhone]->city = $phoneCopy->city;
            $phones[$indexPhone]->number = $phoneCopy->number;
            $phones[$indexPhone]->comment = $phoneCopy->comment;
        }
        return $phones;
    }
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
            [['client_id'], 'integer'],
            ['phone', 'default', 'value' => null],
            [['phone'], 'unique'],
            [['phone'], 'match', 'pattern' => "/[0-9]{11}/"],
            [['comment'], 'string', 'max' => '255'],
            ['country', 'match', 'pattern' => '/\+[7]$/'],
            ['city', 'match', 'pattern' => '/^[0-9]{3}$/'],
            ['number', 'match', 'pattern' => '/^[0-9]{3}-[0-9]{2}-[0-9]{2}$/'],
            [['country', 'city', 'number'], 'required', 'when' => function ($model) {
                return !empty($model->country) || !empty($model->city) || !empty($model->number) || !empty($model->comment);
            }, 'whenClient' => "function (attribute, value) {
                    return $('.item_client_phone input[country]').val() != ''
                     || $('.item_client_phone input[city]').val() != '' 
                     || $('.item_client_phone input[number]').val() != '' 
                     || $('.item_client_phone input[phone-comment]').val() != '';
            }"],
            [['number'], 'validatePhone'],
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
            'phone' => 'Телефон',
            'country' => 'Страна',
            'city' => 'Город',
            'number' => 'Номер',
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->phone = preg_replace("/[^0-9]/", '', $this->country.$this->city.$this->number) ?: null;
            return true;
        } else {
            return false;
        }
    }

    public function validatePhone($attribute, $params)
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

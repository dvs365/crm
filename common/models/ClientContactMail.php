<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_contact_mail".
 *
 * @property integer $id
 * @property integer $contact_id
 * @property string $address
 * @property string $comment
 *
 * @property ClientContact $contact
 */
class ClientContactMail extends \yii\db\ActiveRecord
{
    public static function create(int $id, string $address, string $comment): self
    {
        $ClientContactMail = new ClientContactMail;
        $ClientContactMail->id = $id;
        $ClientContactMail->address = $address;
        $ClientContactMail->comment = $comment;
        return $ClientContactMail;
    }
    /**
     *
     */
    public static function loadMultipleCopy(array $contactMails, array $contactMailsCopy): array
    {
        foreach ($contactMailsCopy as $indexContactMail => $contactMailCopy) {
            if (!isset($contactMails[$indexContactMail])) {
                $contactMails[$indexContactMail] = new ClientContactMail;
                $contactMails[$indexContactMail]->id = $contactMailCopy->id;
            }
            $contactMails[$indexContactMail]->contact_id = $contactMailCopy->contact_id;
            $contactMails[$indexContactMail]->address = $contactMailCopy->address;
            $contactMails[$indexContactMail]->comment = $contactMailCopy->comment;
        }
        return $contactMails;
    }
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'client_contact_mail';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['contact_id'], 'integer'],
			[['address'], 'email'],

            [['address', 'comment'], 'string', 'max' => 255],
            [['address', 'comment'], 'trim'],

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
			'address' => 'E-mail',
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
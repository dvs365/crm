<?php

namespace common\models;

use Yii;


/**
 * This is the model class for table "client_copy".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_add_id
 * @property string $name
 * @property string $anchor
 * @property string $update
 *
 * @property ClientAddressCopy[] $clientAddressCopies
 * @property ClientContactCopy[] $clientContactCopies
 * @property Client $id0
 * @property ClientJurCopy[] $clientJurCopies
 * @property ClientMailCopy[] $clientMailCopies
 * @property ClientPhoneCopy[] $clientPhoneCopies
 */
class ClientCopy extends \yii\db\ActiveRecord
{

    /**
     *
     */
    public static function create(int $id, int $userID, int $userAddID, string $name, string $anchor, string $update): self
    {
        $clientCopy = new ClientCopy;
        $clientCopy->id = $id;
        $clientCopy->user_id = $userID;
        $clientCopy->user_add_id = $userAddID;
        $clientCopy->name = $name;
        $clientCopy->anchor = $anchor;
        $clientCopy->update = $update;
        return $clientCopy;
    }

    public static function isset(int $id): bool
    {
        return ClientCopy::findOne($id) !== null;
    }

    public static function return(int $id)
    {
        $model = ClientCopy::findOne($id);
        $modelCopy = Client::create($model->id, $model->user_id, $model->user_add_id, $model->name, $model->anchor, $model->update);
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($modelCopy->save(false)) {
                foreach ($model->clientJurs as $modelClientJur) {
                    $clientJurCopies = ClientJur::create($modelClientJur->id, $modelClientJur->client_id, $modelClientJur->name);
                    if (!$clientJurCopies->save(false)) {
                        $transaction->rollBack();
                    }
                }
                foreach ($model->clientPhones as $modelClientPhone) {
                    $clientPhoneCopies = ClientPhone::create($modelClientPhone->id, $modelClientPhone->client_id, $modelClientPhone->phone, $modelClientPhone->country, $modelClientPhone->city, $modelClientPhone->number, $modelClientPhone->comment);
                    if (!$clientPhoneCopies->save(false)) {
                        $transaction->rollBack();
                    }
                }
                foreach ($model->clientMails as $modelClientMail) {
                    $clientMailCopies = ClientMail::create($modelClientMail->id, $modelClientMail->client_id, $modelClientMail->address, $modelClientMail->comment);
                    if (!$clientMailCopies->save(false)) {
                        $transaction->rollBack();
                    }
                }
                foreach ($model->clientContacts as $modelClientContact) {
                    $clientContactCopies = ClientContact::create($modelClientContact->id, $modelClientContact->client_id, $modelClientContact->name, $modelClientContact->main, $modelClientContact->position);
                    if (!$clientContactCopies->save(false)) {
                        $transaction->rollBack();
                    }
                    foreach ($modelClientContact->clientContactPhones as $mClientContactPhone) {
                        $clientContactPhoneCopies = ClientContactPhone::create($mClientContactPhone->id, $mClientContactPhone->contact_id, $mClientContactPhone->phone, $mClientContactPhone->country, $mClientContactPhone->city, $mClientContactPhone->number, $mClientContactPhone->comment);
                        if (!$clientContactPhoneCopies->save(false)) {
                            $transaction->rollBack();
                        }
                    }
                    foreach ($modelClientContact->clientContactMails as $mClientContactMail) {
                        $clientContactMailCopies = ClientContactMail::create($mClientContactMail->id, $mClientContactMail->contact_id, $mClientContactMail->address, $mClientContactMail->comment);
                        if (!$clientContactMailCopies->save(false)) {
                            $transaction->rollBack();
                        }
                    }
                }
                foreach ($model->clientAddresses as $mClientAddress) {
                    $clientAddressCopies = ClientAddress::create($mClientAddress->id, $mClientAddress->client_id, $mClientAddress->country, $mClientAddress->region, $mClientAddress->city, $mClientAddress->street, $mClientAddress->home, $mClientAddress->comment, $mClientAddress->note);
                    if (!$clientAddressCopies->save(false)) {
                        $transaction->rollBack();
                    }
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name'], 'required'],
            [['id', 'user_id', 'user_add_id'], 'integer'],
            [['anchor'], 'string'],
            [['update'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'user_add_id' => 'User Add ID',
            'name' => 'Name',
            'anchor' => 'Anchor',
            'update' => 'Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAddressCopies()
    {
        return $this->hasMany(ClientAddressCopy::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactCopies()
    {
        return $this->hasMany(ClientContactCopy::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Client::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientJurCopies()
    {
        return $this->hasMany(ClientJurCopy::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientMailCopies()
    {
        return $this->hasMany(ClientMailCopy::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPhoneCopies()
    {
        return $this->hasMany(ClientPhoneCopy::className(), ['client_id' => 'id']);
    }
}
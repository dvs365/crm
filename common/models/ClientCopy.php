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
    public static function create(int $id, int $userID, int $userAddID, string $name, string $anchor, string $show, string $update): self
    {
        $clientCopy = new ClientCopy;
        $clientCopy->id = $id;
        $clientCopy->user_id = $userID;
        $clientCopy->user_add_id = $userAddID;
        $clientCopy->name = $name;
        $clientCopy->anchor = $anchor;
        $clientCopy->showed_at = $show;
        $clientCopy->updated_at = $update;
        return $clientCopy;
    }

    public static function isCreated(int $id): bool
    {
        return ClientCopy::find()->where(['id' => $id])->exists();
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
            'name' => 'Условное название',
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
    public function getClientAddressCopiesID()
    {
        return $this->hasMany(ClientAddressCopy::className(), ['client_id' => 'id'])->indexBy('id');
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
    public function getClientContactCopiesID()
    {
        return $this->hasMany(ClientContactCopy::className(), ['client_id' => 'id'])->indexBy('id');
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
    public function getClientJurCopiesID()
    {
        return $this->hasMany(ClientJurCopy::className(), ['client_id' => 'id'])->indexBy('id');
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
    public function getClientMailCopiesID()
    {
        return $this->hasMany(ClientMailCopy::className(), ['client_id' => 'id'])->indexBy('id');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPhoneCopies()
    {
        return $this->hasMany(ClientPhoneCopy::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPhoneCopiesID()
    {
        return $this->hasMany(ClientPhoneCopy::className(), ['client_id' => 'id'])->indexBy('id');
    }
}
<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_contact_copy".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 * @property string $main
 * @property string $position
 *
 * @property ClientCopy $client
 * @property ClientContactMailCopy[] $clientContactMailCopies
 * @property ClientContactPhoneCopy[] $clientContactPhoneCopies
 */
class ClientContactCopy extends \yii\db\ActiveRecord
{
    public static function create(int $id, int $client_id, string $name, string $main, string $position): self
    {
        $clientContactCopy = new ClientContactCopy;
        $clientContactCopy->id = $id;
        $clientContactCopy->client_id = $client_id;
        $clientContactCopy->name = $name;
        $clientContactCopy->main = $main;
        $clientContactCopy->position = $position;
        return $clientContactCopy;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_contact_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'client_id'], 'required'],
            [['client_id'], 'integer'],
            [['main'], 'string'],
            [['name', 'position'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientCopy::className(), 'targetAttribute' => ['client_id' => 'id']],
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
            'name' => 'Name',
            'main' => 'Main',
            'position' => 'Position',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(ClientCopy::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactMailCopies()
    {
        return $this->hasMany(ClientContactMailCopy::className(), ['contact_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactPhoneCopies()
    {
        return $this->hasMany(ClientContactPhoneCopy::className(), ['contact_id' => 'id']);
    }
}
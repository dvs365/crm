<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_jur_copy".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 *
 * @property ClientCopy $client
 */
class ClientJurCopy extends \yii\db\ActiveRecord
{
    public static function create(int $id, int $client_id, string $name): self
    {
        $clientJurCopy = new ClientJurCopy;
        $clientJurCopy->id = $id;
        $clientJurCopy->client_id = $client_id;
        $clientJurCopy->name = $name;
        return $clientJurCopy;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_jur_copy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['client_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(ClientCopy::className(), ['id' => 'client_id']);
    }
}
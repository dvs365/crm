<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client_jur".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 *
 * @property Client $client
 */
class ClientJur extends \yii\db\ActiveRecord
{
    /**
     *
     */
    public static function loadMultipleCopy(array $jurs, array $jursCopy): array
    {
        foreach ($jursCopy as $indexJur => $jurCopy) {
            if (!isset($jurs[$indexJur])) {
                $jurs[$indexJur] = new ClientJur;
                $jurs[$indexJur]->id = $jurCopy->id;
            }
            $jurs[$indexJur]->client_id = $jurCopy->client_id;
            $jurs[$indexJur]->name = $jurCopy->name;
        }
        return $jurs;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_jur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
			[['client_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Полное название юр. лица',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}

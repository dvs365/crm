<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property integer $user
 * @property string $name
 *
 * @property User $user0
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'name'], 'required'],
            [['user'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['user'], 'unique'],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}

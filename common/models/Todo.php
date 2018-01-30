<?php

namespace common\models;

use yii\db\Query;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "todo".
 *
 * @property integer $id
 * @property integer $client_id
 * @property string $name
 * @property string $time_from
 * @property string $time_to
 * @property string $repeat
 */
class Todo extends ActiveRecord
{
    public $date;
    public $time;
    public $date1;
    public $date2;

    const REPEAT_NO = 0;
    const REPEAT_DAY = 10;
    const REPEAT_WEEK = 20;
    const REPEAT_MONTH = 30;
    const REPEAT_YEAR = 40;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date', 'date1'], 'required', 'when' => function ($model) {
                return empty($model->date) && empty($model->date1);
            }, 'whenClient' => "function (attribute, value) {
					return ($('#date').val() == '' && $('#datestart').val() == '');
			}"],
            ['name', 'trim'],
            [['client_id', 'user_id'], 'integer'],
            ['client_id', 'default', 'value' => '0'],
            [['date', 'date1', 'date2'], 'date', 'format' => 'php:d.m.Y'],
            ['time', 'date', 'format' => 'php:H:i'],
            [['time_from', 'time_to'], 'safe'],
            ['repeat', 'in', 'range' => [self::REPEAT_NO, self::REPEAT_DAY, self::REPEAT_WEEK, self::REPEAT_MONTH, self::REPEAT_YEAR]],
            [['name'], 'string', 'max' => 255],
            [['desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'ID клиента',
            'name' => 'Название',
            'desc' => 'Описание',
            'time_from' => 'Начать',
            'time_to' => 'Закончить',
            'repeat' => 'Повторять',
            'user_id' => 'ID пользователя',
        ];
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function setTimeFrom()
    {
        if ($this->date) {
            return \DateTime::createFromFormat('d.m.Y', $this->date)->format('Y-m-d');
        }

        if ($this->date1) {
            return \DateTime::createFromFormat('d.m.Y', $this->date1)->format('Y-m-d');
        }
        return false;
    }

    public function setTimeTo()
    {
        if ($this->date && $this->time) {
            return \DateTime::createFromFormat('d.m.Y H:i', $this->date . ' ' . $this->time)->format('Y-m-d H:i');
        }

        if ($this->date) {
            return \DateTime::createFromFormat('d.m.Y', $this->date)->format('Y-m-d 23:59');
        }

        if ($this->date2) {
            return \DateTime::createFromFormat('d.m.Y', $this->date2)->format('Y-m-d 23:59');
        }

        if ($this->date1 && $this->repeat !== self::REPEAT_NO) {
            return \DateTime::createFromFormat('d.m.Y', $this->date1)->format('9999-m-d 23:59');
        }

        if ($this->date1) {
            return \DateTime::createFromFormat('d.m.Y', $this->date1)->format('Y-m-d 23:59');
        }

        return false;
    }

    //return ($this->repeat === 'none') ? Yii::$app->formatter->asDate($this->time_to) : false;
    public function getDate()
    {
        return ($this->repeat === self::REPEAT_NO) ? \DateTime::createFromFormat('Y-m-d H:i:s', $this->time_to)->format('d.m.Y') : false;
    }

    public function getTime()
    {
        return ($this->repeat === self::REPEAT_NO) ? \DateTime::createFromFormat('Y-m-d H:i:s', $this->time_to)->format('H:i') : false;
    }

    public function getDate1()
    {
        return ($this->repeat !== self::REPEAT_NO) ? \DateTime::createFromFormat('Y-m-d H:i:s', $this->time_from)->format('d.m.Y') : false;
    }

    public function getDate2()
    {
        return ($this->repeat !== self::REPEAT_NO) ? \DateTime::createFromFormat('Y-m-d H:i:s', $this->time_to)->format('d.m.Y') : false;
    }

}
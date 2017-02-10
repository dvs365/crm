<?php

namespace common\models;

use Yii;

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
class Todo extends \yii\db\ActiveRecord
{
	public $date;
	public $time;
	public $date1;
	public $date2;

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
			}", 'message' => 'Неодходимо запольнить дату'],
			['name', 'trim'],
			[['client_id'], 'integer'],
			['client_id', 'default', 'value' => '0'],
			[['date', 'date1', 'date2'], 'date', 'format' => 'php:d.m.Y'],
			['time', 'date', 'format' => 'php:H:i'],
			[['time_from', 'time_to'], 'safe'],
			[['repeat'], 'string'],
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
			'client_id' => 'Client ID',
			'name' => 'Название',
			'desc' => 'Описание',
			'time_from' => 'Начать',
			'time_to' => 'Закончить',
			'repeat' => 'Repeat',
		];
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

		if ($this->date1 && $this->repeat !== 'none') {
			return \DateTime::createFromFormat('d.m.Y', $this->date1)->format('9999-m-d 23:59');
		}

		if ($this->date1) {
			return \DateTime::createFromFormat('d.m.Y', $this->date1)->format('Y-m-d 23:59');
		}

		return false;
	}

	public function getDate()
	{
		return ($this->repeat === 'none') ? Yii::$app->formatter->asDate($this->time_to) : false;
	}

	public function getTime()
	{
		return ($this->repeat === 'none') ? Yii::$app->formatter->asTime($this->time_to) : false;
	}

	public function getDate1()
	{
		return ($this->repeat !== 'none') ? Yii::$app->formatter->asDate($this->time_from) : false;
	}

	public function getDate2()
	{
		return ($this->repeat !== 'none') ? Yii::$app->formatter->asDate($this->time_to) : false;
	}

}
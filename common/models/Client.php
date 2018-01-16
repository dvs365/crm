<?php

namespace common\models;

use yii\db\Query;
use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 *
 * @property User $user
 * @property ClientContact[] $clientContacts
 * @property ClientJur[] $clientJurs
 * @property ClientMail[] $clientMails
 * @property ClientPhone[] $clientPhones
 */
class Client extends \yii\db\ActiveRecord
{

    const STATUS_FREE = 0;
    const STATUS_TARGET = 10;
    const STATUS_LOAD = 20;
    const STATUS_REJECT = 30;

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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'trim'],

            [['user_id'], 'integer'],

            [['user_add_id'], 'integer'],
            ['user_add_id', 'default', 'value' => '0'],
            ['user_add_id', 'filter', 'filter' => 'intval'],

            [['anchor'], 'string'],

            ['status', 'default', 'value' => self::STATUS_FREE],
            ['status', 'in', 'range' => [self::STATUS_FREE, self::STATUS_TARGET, self::STATUS_LOAD, self::STATUS_REJECT]],

            ['user_id', 'filter', 'filter' => 'intval'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     *
     */
    public static function loadMultipleCopy($client, $clientCopy)
    {
        $client->user_id = $clientCopy->user_id;
        $client->user_add_id = $clientCopy->user_add_id;
        $client->name = $clientCopy->name;
        $client->anchor = $clientCopy->anchor;
        $client->updated_at = $clientCopy->updated_at;
        $client->showed_at = $clientCopy->showed_at;
        $client->status = $clientCopy->status;
        return $client;
    }

    function getStatusesLabel() {
        return [
            self::STATUS_TARGET => 'потенциальные',
            self::STATUS_LOAD => 'рабочие',
            self::STATUS_REJECT => 'отказные'
        ];
    }

    function getStatusLabel() {
        $statuses = $this->getStatusesLabel();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }

    function  getStatusesColor() {
        return [
            self::STATUS_TARGET => 'orange',
            self::STATUS_LOAD => 'green',
            self::STATUS_REJECT => 'silver'
        ];
    }

    function getStatusColor() {
        $statuses = $this->getStatusesColor();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : '';
    }

    public function getIsReject() {
        return $this->status == Client::STATUS_REJECT;
    }

    public function getIsFree() {
        return $this->status == Client::STATUS_FREE;
    }

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'user_id' => 'Менеджер',
			'user_add_id' => 'Дополнительный просмотр User ID',
			'name' => 'Условное название',
			'anchor' => 'Якорный клиент',
			'clientSearch' => 'Общий поиск',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientContacts()
	{
		return $this->hasMany(ClientContact::className(), ['client_id' => 'id'])->orderBy(['client_contact.main' => SORT_DESC]);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactsID()
    {
        return $this->hasMany(ClientContact::className(), ['client_id' => 'id'])->indexBy('id')->orderBy(['client_contact.main' => SORT_DESC]);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientContactPhones()
	{
		return $this->hasMany(ClientContactPhone::className(), ['contact_id' => 'id'])
			->via('clientContacts');
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactPhonesID()
    {
        return $this->hasMany(ClientContactPhone::className(), ['contact_id' => 'id'])->indexBy('id')
            ->via('clientContacts');
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientContactMails()
	{
		return $this->hasMany(ClientContactMail::className(), ['contact_id' => 'id'])
			->via('clientContacts');
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientContactMailsID()
    {
        return $this->hasMany(ClientContactMail::className(), ['contact_id' => 'id'])->indexBy('id')
            ->via('clientContacts');
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientJurs()
	{
		return $this->hasMany(ClientJur::className(), ['client_id' => 'id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientJursID()
    {
        return $this->hasMany(ClientJur::className(), ['client_id' => 'id'])->indexBy('id');
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientMails()
	{
		return $this->hasMany(ClientMail::className(), ['client_id' => 'id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientMailsID()
    {
        return $this->hasMany(ClientMail::className(), ['client_id' => 'id'])->indexBy('id');
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientPhones()
	{
		return $this->hasMany(ClientPhone::className(), ['client_id' => 'id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientPhonesID()
    {
        return $this->hasMany(ClientPhone::className(), ['client_id' => 'id'])->indexBy('id');
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getClientAddresses()
	{
		return $this->hasMany(ClientAddress::className(), ['client_id' => 'id']);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAddressesID()
    {
        return $this->hasMany(ClientAddress::className(), ['client_id' => 'id'])->indexBy('id');
    }

    public function getClientCopy()
    {
        return $this->hasOne(ClientCopy::className(), ['id' => 'id']);
    }

    public function getClientReject()
    {
        return $this->hasOne(ClientReject::className(), ['client_id' => 'id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTodos()
	{
		$todoAll = (new Query())->select('id')->where(['<', 'time_from', date('Y-m-d H:i:00')]);
		//$todoAll->andWhere(['=', 'status', '']);
		$todoAll->from('todo');
		$todoWeek = (new Query())->select('id')->where(['=', 'DAYOFWEEK(time_from)', date('w')+1]);
		$todoWeek->andWhere(['=', 'repeat', 'week']);
		$todoWeek->from('todo');
		$todoMonth = (new Query())->select('id')->where(['=', 'DAYOFMONTH(time_from)', date('j')]);
		$todoMonth->andWhere(['=', 'repeat', 'month']);
		$todoMonth->from('todo');
		$todoYear = (new Query())->select('id')->where(['=', 'DAYOFMONTH(time_from)', date('j')]);
		$todoYear->andWhere(['=', 'MONTH(time_from)', date('n')]);
		$todoYear->andWhere(['=', 'repeat', 'year']);
		$todoYear->from('todo');
		$query = $this->hasMany(Todo::className(), ['client_id' => 'id']);
		$query->where(['id' => $todoAll]);
		$query->andWhere(['OR',	['repeat' => 'none'], ['id' => $todoWeek], ['id' => $todoMonth], ['id' => $todoYear]]);
		$query->orderBy(['todo.time_to' => SORT_ASC]);
		return $query;
	}

	private function pluralize ($count, $text)
	{
		switch($text)  {
			case 'year' :
				return ($count == 1) ? 'год' : $count . ' ' . 'года';
			case 'month' :
				return ($count == 1) ? 'месяц назад' : Yii::$app->formatter->asDate($this->showed_at);
			case 'week' :
				return ($count == 1) ? 'неделю' : $count . ' ' . 'недели';
			case 'day' :
				return ($count == 1) ? 'позавчера' : (($count < 5) ? $count . ' ' . 'дня назад' : $count . ' ' . 'дней назад');
			case 'hour' :
				return ($count < (int)date('H', time())) ? 'сегодня' : 'вчера';
			case 'minute' :
				return 'сегодня';
			case 'second' :
				return 'сегодня';
		}
	}

	public function getAgoTime()
	{
		$datetime1 = new \DateTime($this->showed_at);
		$interval = date_create('now')->diff($datetime1);
		if ( $v = $interval->y >= 1) return $this->pluralize( $interval->y, 'year') . ' назад';
		if ( $v = $interval->m >= 1) return $this->pluralize( $interval->m, 'month');
		if ( $v = $interval->d >= 7  && $v = $interval->m < 1) return $this->pluralize( (int)($interval->d/7), 'week') . ' назад';
		if ( $v = $interval->d >= 1  && $v = $interval->d < 7) return $this->pluralize( $interval->d, 'day');
		if ( $v = $interval->h >= 1) return $this->pluralize( $interval->h, 'hour');
		if ( $v = $interval->i >= 1) return $this->pluralize( $interval->i, 'minute');
		return $this->pluralize( $interval->s, 'second');
	}

}
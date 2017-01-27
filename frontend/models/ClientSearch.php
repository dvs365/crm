<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;

/**
 * ClientSearch represents the model behind the search form about `common\models\Client`.
 */
class ClientSearch extends Client
{

	public $clientSearch;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'user_id', 'user_add_id'], 'integer'],
			[['name', 'anchor', 'clientSearch'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Client::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		/**
		 * настройка параметров сортировки
		 * Важно: должна быть выполнена раньше $this->load($params)
		 * statement below
		 */

		/*Если нужна сортировка*/
/*
		$dataProvider->setSort([
			'attributes' => [
				'id',
				'name',
			]
		]);
*/
		if (! ($this->load($params) && $this->validate())) {
		/**
		 * Жадная загрузка данных моделей для работы сортировки
		 */
//			$query->joinWith(['clientJurs']);
			return $dataProvider;
		}
/*
		$this->addCondition($query, 'id');
		$this->addCondition($query, 'name');
		$this->addCondition($query, 'user_id');
*/

		$query->joinWith('clientJurs')->joinWith('clientPhones')->joinWith('clientMails')->joinWith('clientContacts');
		$query->joinWith('clientContactPhones')->joinWith('clientContactMails');
		$query->where([
			'or',
			'client_jur.name LIKE "%' . $this->clientSearch . '%"',
			'client_phone.phone LIKE "%' . $this->clientSearch. '%"',
			'client_mail.address LIKE "%' . $this->clientSearch. '%"',
			'client_contact.name LIKE "%' . $this->clientSearch. '%"',
			'client_contact_phone.phone LIKE "%' . $this->clientSearch. '%"',
			'client_contact_mail.address LIKE "%' . $this->clientSearch. '%"'
		]);

		return $dataProvider;
	}
}
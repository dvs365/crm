<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Todo;

/**
 * TodoSearch represents the model behind the search form about `common\models\Todo`.
 */
class TodoSearch extends Todo
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'client_id'], 'integer'],
			[['name', 'time_from', 'time_to', 'repeat'], 'safe'],
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
		$query = Todo::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		$this->load($params);

		if (!$this->validate()) {
			// uncomment the following line if you do not want to return any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}

		// grid filtering conditions
		$query->andFilterWhere([
			'id' => $this->id,
			'client_id' => $this->client_id,
			'time_from' => $this->time_from,
			'time_to' => $this->time_to,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'repeat', $this->repeat]);

		return $dataProvider;
	}
}
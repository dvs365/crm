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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user'], 'integer'],
            [['name'], 'safe'],
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user' => $this->user,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
    
	public function attributeLabels()
    {
        return [
			'id' => Yii::t('app', 'ID клиента'),
            'user' => Yii::t('app', 'ID пользователя'),
            'name' => Yii::t('app', 'Название'),
        ];
    }	
}

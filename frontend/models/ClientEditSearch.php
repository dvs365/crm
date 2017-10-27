<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Client;
use common\models\ClientCopy;

/**
 * ClientEditSearch represents the model behind the search form about `common\models\Client`.
 */
class ClientEditSearch extends Client
{

    public $clientEditSearch;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'user_add_id'], 'integer'],
            [['name', 'anchor', 'clientEditSearch'], 'safe'],
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
        if(Yii::$app->user->can('manager')) {
            $query = Client::find()->indexBy('id')->where(['user_id' => Yii::$app->user->id]);
        }
        if(Yii::$app->user->can('moder')) {
            $query = Client::find()->indexBy('id')->where(['in', 'id', ClientCopy::find()->select('id')]);
        }
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

        $dataProvider->setSort([
            'defaultOrder' => ['update' => SORT_DESC],
        ]);

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

//		if(Yii::$app->user->can('manager')) {
//			$this->user_id = Yii::$app->user->id;
//		}

        $query->joinWith('clientJurs')->joinWith('clientPhones')->joinWith('clientMails')->joinWith('clientContacts');
        $query->joinWith('clientContactPhones')->joinWith('clientContactMails');
        $query->where([
            'or',
            'client.name LIKE "%' . $this->clientEditSearch . '%"',
            'client_jur.name LIKE "%' . $this->clientEditSearch . '%"',
            'client_phone.phone LIKE "%' . $this->clientEditSearch. '%"',
            'client_mail.address LIKE "%' . $this->clientEditSearch. '%"',
            'client_contact.name LIKE "%' . $this->clientEditSearch. '%"',
            'client_contact_phone.phone LIKE "%' . $this->clientEditSearch. '%"',
            'client_contact_mail.address LIKE "%' . $this->clientEditSearch. '%"',
        ]);
        if ($this->user_id) {
            $query->AndWhere('client.user_id = ' . $this->user_id);
        }
        if ($this->anchor) {
            $query->AndWhere('client.anchor = \'' . $this->anchor.'\'');
        }
        $query->groupBy(['id']);
        return $dataProvider;
    }
}
<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ArrayDataProvider;
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
        $query = Client::find()->select('client.*')->indexBy('id')
            ->leftJoin('client_copy', Client::tableName() . '.id = ' . ClientCopy::tableName() .'.id')
            ->where(ClientCopy::tableName() . '.updated_at <> ' . Client::tableName() . '.updated_at');

        // add conditions that should always apply here

        $dataProvider = new ArrayDataProvider([
            'allModels' => $query->all(),
            'sort' => [
                'attributes' => ['id','name'],
            ],
            'pagination' => [
                'pageSize' => 10,
                'validatePage' => false,
            ]
        ]);

        /**
         * настройка параметров сортировки
         * Важно: должна быть выполнена раньше $this->load($params)
         * statement below
         */

        /*Если нужна сортировка*/
/*
        $dataProvider->setSort([
            'defaultOrder' => ['update' => SORT_DESC],
        ]);
*/

        if (! ($this->load($params) && $this->validate())) {
            /**
             * Жадная загрузка данных моделей для работы сортировки
             */
//			$query->joinWith(['clientJurs']);
            return $dataProvider;
        }

        $query->joinWith('clientJurs')->joinWith('clientPhones')->joinWith('clientMails')->joinWith('clientContacts');
        $query->joinWith('clientContactPhones')->joinWith('clientContactMails');
        if ($this->clientEditSearch && mb_strlen($this->clientEditSearch) > 3) {
            $searchPhone = str_replace([' ', '-'], '', $this->clientEditSearch);
            if (is_numeric($searchPhone)) {
                $query->AndWhere([
                    "or",
                    "client_phone.phone LIKE '%" . $searchPhone. "%'",
                    "client_contact_phone.phone LIKE '%" . $searchPhone. "%'",
                ]);
            } else {
                $query->AndWhere([
                    "or",
                    "client.name LIKE '%" . $this->clientEditSearch . "%'",
                    "client_jur.name LIKE '%" . $this->clientEditSearch . "%'",
                    "client_mail.address LIKE '%" . $this->clientEditSearch. "%'",
                    "client_contact.name LIKE '%" . $this->clientEditSearch. "%'",
                    "client_phone.comment LIKE '%" . $this->clientEditSearch. "%'",
                    "client_contact_phone.comment LIKE '%" . $this->clientEditSearch. "%'",
                    "client_contact_mail.address LIKE '%" . $this->clientEditSearch. "%'",
                ]);
            }
        }

        if ($this->user_id) {
            $query->AndWhere('client.user_id = ' . $this->user_id);
        }
        if ($this->anchor) {
            $query->AndWhere('client.anchor = \'' . $this->anchor.'\'');
        }
        $dataProvider->allModels = $query->all();

        /*
                $this->addCondition($query, 'id');
                $this->addCondition($query, 'name');
                $this->addCondition($query, 'user_id');
        */

//		if(Yii::$app->user->can('manager')) {
//			$this->user_id = Yii::$app->user->id;
//		}



        $query->groupBy(['id']);
        return $dataProvider;
    }
}
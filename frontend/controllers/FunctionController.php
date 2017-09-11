<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Client;
use common\models\ClientCopy;
use app\models\ClientSearch;

class FunctionController extends \yii\web\Controller
{
    public function actionIndex()
    {
        //$this->backupClientRest();
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelsUser' =>  User::find()->all(),
        ]);
    }

    public function actionRecopy(int $id)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        if (!ClientCopy::findOne($id)->delete() || !Client::backup($id)) {
            $transaction->rollback();
            return false;
        }
        $transaction->commit();
        return true;
    }

    public function actionReturn($id)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        if (!Client::findOne($id)->delete() || !ClientCopy::return($id)) {
            $transaction->rollback();
            return false;
        }
        $transaction->commit();
        return true;
    }

    public function backupClientRest()
    {
        $modelsID = Client::find()->select('id')->where(['not in', 'id', ClientCopy::find()->select('id')])->all();
        foreach ($modelsID as $modelID) {
            Client::backup($modelID->id);
        }
    }
}
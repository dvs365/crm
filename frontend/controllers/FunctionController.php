<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\services\client\ClientCopyService;
use common\models\User;
use common\models\Client;
use common\models\ClientCopy;
use app\models\ClientSearch;

class FunctionController extends Controller
{
    private $clientCopyService;

    public function __construct(
        $id,
        $module,
        ClientCopyService $clientCopyService,
        $config =[])
    {
        parent::__construct($id, $module, $config);
        $this->clientCopyService = $clientCopyService;
    }

    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelsUser' =>  User::find()->all(),
        ]);
    }

    public function actionCopy(int $id)
    {
        try {
            $this->clientCopyService->backup($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function actionOriginal(int $id): bool
    {
        try {
            if ($model = Client::findOne($id)) {
                $model->delete();
                return true;
            }
            $this->clientCopyService->recovery($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    public function backupClientRest()
    {
        $modelsID = Client::find()->select('id')->where(['not in', 'id', ClientCopy::find()->select('id')])->all();
        foreach ($modelsID as $modelID) {
            $this->clientCopyService->backup($modelID->id);
        }
    }
}
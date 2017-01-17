<?php

namespace frontend\controllers;

use Yii;
use common\models\Client;
use common\models\ClientJur;
use app\models\ClientSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\base\Model;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['index', 'create'],
				'rules' => [
					[
						'actions' => ['index'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['create'],
						'allow' => true,
						'roles' => ['createClient'],
					],
				],
			],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * Lists all Client models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Client model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		if (! \Yii::$app->user->can('updateClient', ['client' => $model])) {
			throw new ForbiddenHttpException('Нет разрешения на просмотр клиента"'.$model->name.'"');
		}
		$modelsClientJur = $model->clientJurs;
        return $this->render('view', [
            'model' => $model,
			'modelsClientJur' => $modelsClientJur,
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Client;
		$modelsClientJur = [new ClientJur];

		if ($model->load(Yii::$app->request->post())) {
			$modelsClientJur = Model::createMultiple(ClientJur::classname());
			Model::loadMultiple($modelsClientJur, Yii::$app->request->post());

			$model->user_id = Yii::$app->user->id;

			// validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsClientJur) && $valid;
			if ($valid) {
				$transaction = \Yii::$app->db->beginTransaction();
				try {
					if ($flag = $model->save(false)) {
						foreach ($modelsClientJur as $modelClientJur) {
							$modelClientJur->client_id = $model->id;
							if (! ($flag = $modelClientJur->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
					}

					if ($flag) {
						$transaction->commit();
						return $this->redirect(['view', 'id' => $model->id]);
					}
				} catch (Exception $e) {
					$transaction->rollBack();
				}
			}
        }
		return $this->render('create', [
			'model' => $model,
			'modelsClientJur' => (empty($modelsClientJur)) ? [new ClientJur] : $modelsClientJur
		]);

    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
		$model = $this->findModel($id);

		if (! \Yii::$app->user->can('updateClient', ['client' => $model])) {
			throw new ForbiddenHttpException('Нет разрешения на редактирование клиента"'.$model->name.'"');
		}

		$modelsClientJur = $model->clientJurs;

        if ($model->load(Yii::$app->request->post())) {

			$oldIDs = ArrayHelper::map($modelsClientJur, 'id', 'id');
			$modelsClientJur = Model::createMultiple(ClientJur::classname(), $modelsClientJur);
			Model::loadMultiple($modelsClientJur, Yii::$app->request->post());
			$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsClientJur, 'id', 'id')));

			//validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsClientJur) && $valid;

			if ($valid) {
				$transaction = \Yii::$app->db->beginTransaction();
				try {
					if ($flag = $model->save(false)) {
						if (!empty($deletedIDs)) {
							ClientJur::deleteAll(['id' => $deletedIDs]);
						}
						foreach ($modelsClientJur as $modelClientJur) {
							$modelClientJur->client_id = $model->id;
							if (! ($flag = $modelClientJur->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
					}
					if ($flag) {
						$transaction->commit();
						return $this->redirect(['view', 'id' => $model->id]);
					}
				} catch (Exception $e) {
					$transaction->rollBack();
				}
			}
        }

		return $this->render('update', [
			'model' => $model,
			'modelsClientJur' => (empty($modelsClientJur)) ? [new ClientJur] : $modelsClientJur
		]);

    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		if (! \Yii::$app->user->can('deleteClient', ['client' => $model])) {
			throw new ForbiddenHttpException('Нет разрешения на удаление клиента"'.$model->name.'"');
		}
		$modelsClientJur = $model->clientJurs;
		$transaction = \Yii::$app->db->beginTransaction();
		foreach ($modelsClientJur as $modelClientJur) {
			$modelClientJur->delete();
		}
		if (! $flagModel = $model->delete()) {
			throw new ForbiddenHttpException('Удаление клиента "'.$model->name.'" не удалось!');
			$transaction->rollBack();
		} else {
			$transaction->commit();
		}
		return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

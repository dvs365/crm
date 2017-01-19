<?php

namespace frontend\controllers;

use Yii;
use common\models\Client;
use common\models\ClientJur;
use common\models\ClientPhone;
use common\models\ClientMail;
use common\models\ClientContact;
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
		$modelsClientPhone = $model->clientPhones;
		$modelsClientMail = $model->clientMails;
        return $this->render('view', [
            'model' => $model,
			'modelsClientJur' => $modelsClientJur,
			'modelsClientPhone' => $modelsClientPhone,
			'modelsClientMail' => $modelsClientMail,
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
		$modelsClientPhone = [new ClientPhone];
		$modelsClientMail = [new ClientMail];
		$modelsClientContact = [new ClientContact];

		if ($model->load(Yii::$app->request->post())) {
			$modelsClientJur = Model::createMultiple(ClientJur::classname());
			$modelsClientPhone = Model::createMultiple(ClientPhone::classname());
			$modelsClientMail = Model::createMultiple(ClientMail::classname());
			$modelsClientContact = Model::createMultiple(ClientContact::classname());
			Model::loadMultiple($modelsClientJur, Yii::$app->request->post());
			Model::loadMultiple($modelsClientPhone, Yii::$app->request->post());
			Model::loadMultiple($modelsClientMail, Yii::$app->request->post());
			Model::loadMultiple($modelsClientContact, Yii::$app->request->post());

			$model->user_id = Yii::$app->user->id;

			// validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsClientJur) && $valid;
			$valid = Model::validateMultiple($modelsClientPhone) && $valid;
			$valid = Model::validateMultiple($modelsClientMail) && $valid;
			$valid = Model::validateMultiple($modelsClientContact) && $valid;

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
						foreach ($modelsClientPhone as $modelClientPhone) {
							$modelClientPhone->client_id = $model->id;
							if (! ($flag = $modelClientPhone->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
						foreach ($modelsClientMail as $modelClientMail) {
							$modelClientMail->client_id = $model->id;
							if (! ($flag = $modelClientMail->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
						foreach ($modelsClientContact as $modelClientContact) {
							$modelClientContact->client_id = $model->id;
							if (! ($flag = $modelClientContact->save(false))) {
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
			'modelsClientJur' => (empty($modelsClientJur)) ? [new ClientJur] : $modelsClientJur,
			'modelsClientPhone' => (empty($modelsClientPhone)) ? [new ClientPhone] : $modelsClientPhone,
			'modelsClientMail' => (empty($modelsClientMail)) ? [new ClientMail] : $modelsClientMail,
			'modelsClientContact' => (empty($modelsClientContact)) ? [new ClientContact] : $modelsClientContact,
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
		$modelsClientPhone = $model->clientPhones;
		$modelsClientMail = $model->clientMails;
		$modelsClientContact = $model->clientContacts;

        if ($model->load(Yii::$app->request->post())) {

			$oldIDsJur = ArrayHelper::map($modelsClientJur, 'id', 'id');
			$oldIDsPhone = ArrayHelper::map($modelsClientPhone, 'id', 'id');
			$oldIDsMail = ArrayHelper::map($modelsClientMail, 'id', 'id');
			$oldIDsContact = ArrayHelper::map($modelsClientContact, 'id', 'id');
			$modelsClientJur = Model::createMultiple(ClientJur::classname(), $modelsClientJur);
			$modelsClientPhone = Model::createMultiple(ClientPhone::classname(), $modelsClientPhone);
			$modelsClientMail = Model::createMultiple(ClientMail::classname(), $modelsClientMail);
			$modelsClientContact = Model::createMultiple(ClientContact::classname(), $modelsContact);
			Model::loadMultiple($modelsClientJur, Yii::$app->request->post());
			Model::loadMultiple($modelsClientPhone, Yii::$app->request->post());
			Model::loadMultiple($modelsClientMail, Yii::$app->request->post());
			Model::loadMultiple($modelsClientContact, Yii::$app->request->post());
			$deletedIDsJur = array_diff($oldIDsJur, array_filter(ArrayHelper::map($modelsClientJur, 'id', 'id')));
			$deletedIDsPhone = array_diff($oldIDsPhone, array_filter(ArrayHelper::map($modelsClientPhone, 'id', 'id')));
			$deletedIDsMail = array_diff($oldIDsMail, array_filter(ArrayHelper::map($modelsClientMail, 'id', 'id')));
			$deletedIDsContact = array_diff($oldIDsContact, array_filter(ArrayHelper::map($modelsClientContact, 'id', 'id')));

			//validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsClientJur) && $valid;
			$valid = Model::validateMultiple($modelsClientPhone) && $valid;
			$valid = Model::validateMultiple($modelsClientMail) && $valid;
			$valid = Model::validateMultiple($modelsClientContact) && $valid;

			if ($valid) {
				$transaction = \Yii::$app->db->beginTransaction();
				try {
					if ($flag = $model->save(false)) {
						if (!empty($deletedIDsJur)) {
							ClientJur::deleteAll(['id' => $deletedIDsJur]);
						}
						if (!empty($deletedIDsPhone)) {
							ClientPhone::deleteAll(['id' => $deletedIDsPhone]);
						}
						if (!empty($deletedIDsMail)) {
							ClientMail::deleteAll(['id' => $deletedIDsMail]);
						}
						if (!empty($deletedIDsContact)) {
							ClientContact::deleteAll(['id' => $deletedIDsContact]);
						}
						foreach ($modelsClientJur as $modelClientJur) {
							$modelClientJur->client_id = $model->id;
							if (! ($flag = $modelClientJur->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
						foreach ($modelsClientPhone as $modelClientPhone) {
							$modelClientPhone->client_id = $model->id;
							if (! ($flag = $modelClientPhone->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
						foreach ($modelsClientMail as $modelClientMail) {
							$modelClientMail->client_id = $model->id;
							if (! ($flag = $modelClientMail->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
						foreach ($modelsClientContact as $modelClientContact) {
							$modelClientContact->client_id = $model->id;
							if (! ($flag = $modelClientContact->save(false))) {
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
			'modelsClientJur' => (empty($modelsClientJur)) ? [new ClientJur] : $modelsClientJur,
			'modelsClientPhone' => (empty($modelsClientPhone)) ? [new ClientPhone] : $modelsClientPhone,
			'modelsClientMail' => (empty($modelsClientMail)) ? [new ClientMail] : $modelsClientMail,
			'modelsClientContact' => (empty($modelsClientContact)) ? [new ClientContact] : $modelsClientContact,
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
		$modelsClientPhone = $model->clientPhones;
		$modelsClientMail = $model->clientMails;
		$modelsClientContact = $model->clientContacts;
		$transaction = \Yii::$app->db->beginTransaction();
		foreach ($modelsClientJur as $modelClientJur) {
			$modelClientJur->delete();
		}
		foreach ($modelsClientPhone as $modelClientPhone) {
			$modelClientPhone->delete();
		}
		foreach ($modelsClientMail as $modelClientMail) {
			$modelClientMail->delete();
		}
		foreach ($modelsClientContact as $modelClientContact) {
			$modelClientContact->delete();
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

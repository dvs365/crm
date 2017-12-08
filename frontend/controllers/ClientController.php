<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Client;
use common\models\ClientJur;
use common\models\ClientPhone;
use common\models\ClientMail;
use common\models\ClientContact;
use common\models\ClientContactPhone;
use common\models\ClientContactMail;
use common\models\ClientAddress;
use common\models\ClientReject;
use app\models\ClientSearch;
use frontend\services\client\ClientCopyService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
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
//				'only' => ['index', 'create', 'update', 'view'],
				'rules' => [
					[
//						'actions' => ['index','view', 'update', 'create'],
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
			'modelsUser' =>  User::find()->all(),
        ]);
    }

	/**
	 * Lists all Client models.
	 * @return mixed
	 */
	public function actionFree()
	{
		$searchModel = new ClientSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => Client::STATUS_FREE]);
		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'modelsUser' =>  User::find()->all(),
		]);
	}


    /**
     * Lists Client models.
     * @return mixed
     */
    public function actionTarget()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => Client::STATUS_TARGET]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelsUser' =>  User::find()->all(),
        ]);
    }

    /**
     * work
     */
    public function actionLoad()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => Client::STATUS_LOAD]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelsUser' =>  User::find()->all(),
        ]);
    }
    /**
     * reject
     */

    public function actionReject()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['status' => Client::STATUS_REJECT]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelsUser' =>  User::find()->all(),
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
		$model->showed_at = date('Y-m-d H:i:s');
		$model->save(false);
        return $this->render('view', [
            'model' => $model,
            'reject' => new ClientReject,
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
		$modelsClientContactPhone = [[new ClientContactPhone]];
        $modelsClientContactMail = [[new ClientContactMail]];
        $modelsClientAddress = [new ClientAddress];
        $clientCopyService = new ClientCopyService;

        if ($model->load(Yii::$app->request->post())) {
            $modelsClientJur = Model::createMultiple(ClientJur::classname());
            $modelsClientPhone = Model::createMultiple(ClientPhone::classname());
            $modelsClientMail = Model::createMultiple(ClientMail::classname());
            $modelsClientContact = Model::createMultiple(ClientContact::classname());
            $modelsClientAddress = Model::createMultiple(ClientAddress::classname());
            Model::loadMultiple($modelsClientJur, Yii::$app->request->post());
            Model::loadMultiple($modelsClientPhone, Yii::$app->request->post());
            Model::loadMultiple($modelsClientMail, Yii::$app->request->post());
            Model::loadMultiple($modelsClientContact, Yii::$app->request->post());
            Model::loadMultiple($modelsClientAddress, Yii::$app->request->post());

            $model->user_id = ($model->user_id) ?: Yii::$app->user->id;
            $model->status = empty($model->user_id)? Client::STATUS_FREE : Client::STATUS_TARGET;

            // validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsClientJur) && $valid;
			$valid = Model::validateMultiple($modelsClientPhone) && $valid;
			$valid = Model::validateMultiple($modelsClientMail) && $valid;
			$valid = Model::validateMultiple($modelsClientContact) && $valid;
			$valid = Model::validateMultiple($modelsClientAddress) && $valid;

			if (isset($_POST['ClientContactPhone'][0][0])) {
				foreach ($_POST['ClientContactPhone'] as $indexContact => $phones) {
					foreach ($phones as $indexPhone => $phone) {
						$data['ClientContactPhone'] = $phone;
						$modelClientContactPhone = new ClientContactPhone;
						$modelClientContactPhone->load($data);
						$modelsClientContactPhone[$indexContact][$indexPhone] = $modelClientContactPhone;
						$valid = $modelClientContactPhone->validate();
					}
				}
			}
			if (isset($_POST['ClientContactMail'][0][0])) {
				foreach ($_POST['ClientContactMail'] as $indexContact => $mails) {
					foreach ($mails as $indexMail => $mail) {
						$data['ClientContactMail'] = $mail;
						$modelClientContactMail = new ClientContactMail;
						$modelClientContactMail->load($data);
						$modelsClientContactMail[$indexContact][$indexMail] = $modelClientContactMail;
						$valid = $modelClientContactMail->validate();
					}
				}
			}

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
                            $phoneCFull = $modelClientPhone->country.$modelClientPhone->city.$modelClientPhone->number;
							$modelClientPhone->phone = preg_replace("/[^0-9]/", '', $phoneCFull) ?: null;
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
						foreach ($modelsClientContact as $indexContact => $modelClientContact) {
							$modelClientContact->client_id = $model->id;
							if (! ($flag = $modelClientContact->save(false))) {
								$transaction->rollBack();
								break;
							}
							if (isset($modelsClientContactPhone[$indexContact]) && is_array($modelsClientContactPhone[$indexContact])) {
								foreach ($modelsClientContactPhone[$indexContact] as $indexPhone => $modelClientContactPhone) {
									$modelClientContactPhone->contact_id = $modelClientContact->id;
									$phoneFull = $modelClientContactPhone->country.$modelClientContactPhone->city.$modelClientContactPhone->number;
									$modelClientContactPhone->phone = preg_replace("/[^0-9]/", '', $phoneFull) ?: null;
									if (! ($flag = $modelClientContactPhone->save(false))) {
										$transaction->rollBack();
										break;
									}
								}
							}
							if (isset($modelsClientContactMail[$indexContact]) && is_array($modelsClientContactMail[$indexContact])) {
								foreach ($modelsClientContactMail[$indexContact] as $indexMail => $modelClientContactMail) {
									$modelClientContactMail->contact_id = $modelClientContact->id;
									if (! ($flag = $modelClientContactMail->save(false))) {
										$transaction->rollBack();
										break;
									}
								}
							}
						}
						foreach ($modelsClientAddress as $modelClientAddress) {
							$modelClientAddress->client_id = $model->id;
							if (! ($flag = $modelClientAddress->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
                        $clientCopyService->backup($model->id);
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
			'modelsClientContactPhone' => (empty($modelsClientContactPhone)) ? [[new ClientContactPhone]] : $modelsClientContactPhone,
			'modelsClientContactMail' => (empty($modelsClientContactMail)) ? [[new ClientContactMail]] : $modelsClientContactMail,
			'modelsClientAddress' => (empty($modelsClientAddress)) ? [new ClientAddress] : $modelsClientAddress,
			'modelsUser' =>  User::find()->all(),
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
			throw new ForbiddenHttpException('Нет разрешения на редактирование клиента "'.$model->name.'"');
		}
        $modelsClientJur = $model->clientJurs;
        $modelsClientPhone = $model->clientPhones;
        $modelsClientMail = $model->clientMails;
        $modelsClientContact = $model->clientContacts;
        $modelsClientAddress = $model->clientAddresses;
        $modelsClientContactPhone = [];
        $oldPhones = [];
        $modelsClientContactMail = [];
        $oldMails = [];

        if (!empty($modelsClientContact)) {
            foreach ($modelsClientContact as $indexContact => $modelClientContact) {
                $phones = $modelClientContact->clientContactPhones;
                $modelsClientContactPhone[$indexContact] = $phones;
                $oldPhones = ArrayHelper::merge(ArrayHelper::index($phones, 'id'), $oldPhones);

                $mails = $modelClientContact->clientContactMails;
                $modelsClientContactMail[$indexContact] = $mails;
                $oldMails = ArrayHelper::merge(ArrayHelper::index($mails, 'id'), $oldMails);
            }
        }

        if ($model->load(Yii::$app->request->post())) {

            //reset
			$modelsClientContactPhone = [];
			$modelsClientContactMail = [];

			$oldIDsJur = ArrayHelper::map($modelsClientJur, 'id', 'id');
			$oldIDsPhone = ArrayHelper::map($modelsClientPhone, 'id', 'id');
			$oldIDsMail = ArrayHelper::map($modelsClientMail, 'id', 'id');
			$oldIDsContact = ArrayHelper::map($modelsClientContact, 'id', 'id');
			$oldIDsAddress = ArrayHelper::map($modelsClientAddress, 'id', 'id');

			$modelsClientJur = Model::createMultiple(ClientJur::classname(), $modelsClientJur);
			$modelsClientPhone = Model::createMultiple(ClientPhone::classname(), $modelsClientPhone);
			$modelsClientMail = Model::createMultiple(ClientMail::classname(), $modelsClientMail);
			$modelsClientContact = Model::createMultiple(ClientContact::classname(), $modelsClientContact);
			$modelsClientAddress = Model::createMultiple(ClientAddress::classname(), $modelsClientAddress);

			Model::loadMultiple($modelsClientJur, Yii::$app->request->post());
			Model::loadMultiple($modelsClientPhone, Yii::$app->request->post());
			Model::loadMultiple($modelsClientMail, Yii::$app->request->post());
			Model::loadMultiple($modelsClientContact, Yii::$app->request->post());
			Model::loadMultiple($modelsClientAddress, Yii::$app->request->post());

			$deletedIDsJur = array_diff($oldIDsJur, array_filter(ArrayHelper::map($modelsClientJur, 'id', 'id')));
			$deletedIDsPhone = array_diff($oldIDsPhone, array_filter(ArrayHelper::map($modelsClientPhone, 'id', 'id')));
			$deletedIDsMail = array_diff($oldIDsMail, array_filter(ArrayHelper::map($modelsClientMail, 'id', 'id')));
			$deletedIDsContact = array_diff($oldIDsContact, array_filter(ArrayHelper::map($modelsClientContact, 'id', 'id')));
			$deletedIDsAddress = array_diff($oldIDsAddress, array_filter(ArrayHelper::map($modelsClientAddress, 'id', 'id')));

            if (empty($model->user_id)) {
                $model->status = Client::STATUS_FREE;
            }

			//validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelsClientJur) && $valid;
			$valid = Model::validateMultiple($modelsClientPhone) && $valid;
			$valid = Model::validateMultiple($modelsClientMail) && $valid;
			$valid = Model::validateMultiple($modelsClientContact) && $valid;
			$valid = Model::validateMultiple($modelsClientAddress) && $valid;

			$phonesIDs = [];
			if (isset($_POST['ClientContactPhone'][0][0])) {
				foreach ($_POST['ClientContactPhone'] as $indexContact => $phones) {
					$phonesIDs = ArrayHelper::merge($phonesIDs, array_filter(ArrayHelper::getColumn($phones, 'id')));
					foreach ($phones as $indexPhone => $phone) {
						$data['ClientContactPhone'] = $phone;
						$modelClientContactPhone = (isset($phone['id']) && isset($oldPhones[$phone['id']])) ? $oldPhones[$phone['id']] : new ClientContactPhone;
						$modelClientContactPhone->load($data);
						$modelsClientContactPhone[$indexContact][$indexPhone] = $modelClientContactPhone;
						$valid = $modelClientContactPhone->validate();
					}
				}
			}

			$oldIDsClientContactPhone = ArrayHelper::getColumn($oldPhones, 'id');
			$deletedIDsContactPhone = array_diff($oldIDsClientContactPhone, $phonesIDs);

			$mailsIDs = [];
			if (isset($_POST['ClientContactMail'][0][0])) {
				foreach ($_POST['ClientContactMail'] as $indexContact => $mails) {
					$mailsIDs = ArrayHelper::merge($mailsIDs, array_filter(ArrayHelper::getColumn($mails, 'id')));
					foreach ($mails as $indexMail => $mail) {
						$data['ClientContactMail'] = $mail;
						$modelClientContactMail = (isset($mail['id']) && isset($oldMails[$mail['id']])) ? $oldMails[$mail['id']] : new ClientContactMail;
						$modelClientContactMail->load($data);
						$modelsClientContactMail[$indexContact][$indexMail] = $modelClientContactMail;
						$valid = $modelClientContactMail->validate();
					}
				}
			}

			$oldIDsClientContactMail = ArrayHelper::getColumn($oldMails, 'id');
			$deletedIDsContactMail = array_diff($oldIDsClientContactMail, $mailsIDs);

			if ($valid) {
				$transaction = \Yii::$app->db->beginTransaction();
				try {
                    $dirty = empty($model->getDirtyAttributes());
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
						if (!empty($deletedIDsContactPhone)) {
							ClientContactPhone::deleteAll(['id' => $deletedIDsContactPhone]);
						}
						if (!empty($deletedIDsContactMail)) {
							ClientContactMail::deleteAll(['id' => $deletedIDsContactMail]);
						}
						if (!empty($deletedIDsContact)) {
							ClientContact::deleteAll(['id' => $deletedIDsContact]);
						}
						if (!empty($deletedIDsAddress)) {
							ClientAddress::deleteAll(['id' => $deletedIDsAddress]);
						}
                        foreach ($modelsClientJur as $modelClientJur) {
                            $modelClientJur->client_id = $model->id;
                            $dirty = $dirty && empty($modelClientJur->getDirtyAttributes());
                            if (! ($flag = $modelClientJur->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelsClientPhone as $modelClientPhone) {
                            $modelClientPhone->client_id = $model->id;
                            $phoneFull = $modelClientPhone->country.$modelClientPhone->city.$modelClientPhone->number;
                            $modelClientPhone->phone = preg_replace("/[^0-9]/", '', $phoneFull) ?: null;
                            $dirty = $dirty && empty($modelClientPhone->getDirtyAttributes());
                            if (! ($flag = $modelClientPhone->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelsClientMail as $modelClientMail) {
                            $modelClientMail->client_id = $model->id;
                            $dirty = $dirty && empty($modelClientMail->getDirtyAttributes());
                            if (! ($flag = $modelClientMail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
						foreach ($modelsClientContact as $indexContact => $modelClientContact) {
							$modelClientContact->client_id = $model->id;
                            $dirty = $dirty && empty($modelClientContact->getDirtyAttributes());
							if (! ($flag = $modelClientContact->save(false))) {
								$transaction->rollBack();
								break;
							}
							if (isset($modelsClientContactPhone[$indexContact]) && is_array($modelsClientContactPhone[$indexContact])) {
								foreach ($modelsClientContactPhone[$indexContact] as $indexPhone => $modelClientContactPhone) {
									$modelClientContactPhone->contact_id = $modelClientContact->id;
                                    $phoneCFull = $modelClientContactPhone->country.$modelClientContactPhone->city.$modelClientContactPhone->number;
									$modelClientContactPhone->phone = preg_replace("/[^0-9]/", '', $phoneCFull) ?: null;
                                    $dirty = $dirty && empty($modelClientContactPhone->getDirtyAttributes());
									if (! ($flag = $modelClientContactPhone->save(false))) {
										$transaction->rollBack();
										break;
									}
								}
							}
							if (isset($modelsClientContactMail[$indexContact]) && is_array($modelsClientContactMail[$indexContact])) {
								foreach ($modelsClientContactMail[$indexContact] as $indexMail => $modelClientContactMail) {
									$modelClientContactMail->contact_id = $modelClientContact->id;
                                    $dirty = $dirty && empty($modelClientContactMail->getDirtyAttributes());
									if (! ($flag = $modelClientContactMail->save(false))) {
										$transaction->rollBack();
										break;
									}
								}
							}
						}
						foreach ($modelsClientAddress as $modelClientAddress) {
							$modelClientAddress->client_id = $model->id;
                            $dirty = $dirty && empty($modelClientAddress->getDirtyAttributes());
							if (! ($flag = $modelClientAddress->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
                        if (!$dirty) {
                            $model->updated_at = date('Y-m-d H:i:s');
                            if (! ($flag = $model->save(false))) {
                                $transaction->rollBack();
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
			'modelsClientContactPhone' => (empty($modelsClientContactPhone)) ? [[new ClientContactPhone]] : $modelsClientContactPhone,
			'modelsClientContactMail' => (empty($modelsClientContactMail)) ? [[new ClientContactMail]] : $modelsClientContactMail,
			'modelsClientAddress' => (empty($modelsClientAddress)) ? [new ClientAddress] : $modelsClientAddress,
			'modelsUser' =>  User::find()->all(),
		]);

    }

	/**
	 * work
	 */

	/**
	 * remove to reject
	 */
	public function actionToreject()
    {
        $reject = new ClientReject;
        if ($reject->load(Yii::$app->request->post())) {
            $client = $this->findModel($reject->client_id);
            if (!\Yii::$app->user->can('updateClient', ['client' => $client])) {
                throw new ForbiddenHttpException('Нет разрешения на редактирование клиента"' . $client->name . '"');
            }
            $client->status = Client::STATUS_REJECT;

            $valid = $client->validate();
            $valid = $reject->validate() && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if (! ($flag = $client->save(false))) {
                        $transaction->rollBack();
                    }
                    if (! ($flag = $reject->save(false))) {
                        $transaction->rollBack();
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['client/reject']);
                    }
                } catch (Exception $e) {
                    $transaction->rolBack();
                }
            }
        }
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
		$modelsClientAddres = $model->clientAddresses;


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
			$phones = $modelClientContact->clientContactPhones;
			foreach ($phones as $modelClientContactPhone) {
				$modelClientContactPhone->delete();
			}

			$mails = $modelClientContact->clientContactMails;
			foreach ($mails as $modelClientContactMail) {
				$modelClientContactMail->delete();
			}

			$modelClientContact->delete();
		}
		foreach ($modelsClientAddres as $modelClientAddres) {
			$modelClientAddres->delete();
		}
		if (! $flagModel = $model->delete()) {
			throw new ForbiddenHttpException('Удаление клиента "'.$model->name.'" не удалось!');
			$transaction->rollBack();
		} else {
			$transaction->commit();
			Yii::$app->session->setFlash('success', 'Record <strong>"'.$model->name.'" </strong> deleted successfully.');
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
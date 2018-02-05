<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\services\client\ClientCopyService;
use common\models\User;
use common\models\Client;
use common\models\ClientCopy;
use app\models\ClientEditSearch;
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
        $clientEditSearch = new ClientEditSearch;
        $clientCopy = ClientCopy::find()->indexBy('id')->all();

        $dataProvider = $clientEditSearch->search(Yii::$app->request->queryParams);
        $modelsClient = $dataProvider->getModels();

        foreach ($modelsClient as $keyClient => $modelClient) {
            $change = new \stdClass;
            $change->name = $modelClient->name === $clientCopy[$keyClient]->name;
            $clientJursDellID = array_keys(array_diff_key($clientCopy[$keyClient]->clientJurCopiesID, $modelClient->clientJursID));
            foreach ($clientJursDellID as $clientJurDellID) {
                $change->jur[$clientJurDellID] = false;
            }
            foreach ($modelClient->clientJursID as $keyJur => $mClientJur) {
                $change->jur[$keyJur] = $mClientJur->name === $clientCopy[$keyClient]->clientJurCopiesID[$keyJur]->name;
            }
            $clientMailsDellID = array_keys(array_diff_key($clientCopy[$keyClient]->clientMailCopiesID, $modelClient->clientMailsID));
            foreach ($clientMailsDellID as $clientMailDellID) {
                $change->mail[$clientMailDellID] = ['address' => false, 'comment' => false];
            }
            foreach ($modelClient->clientMailsID as $keyMail => $mClientMail) {
                $change->mail[$keyMail]['address'] = $mClientMail->address === $clientCopy[$keyClient]->clientMailCopiesID[$keyMail]->address;
                $change->mail[$keyMail]['comment'] = $mClientMail->comment === $clientCopy[$keyClient]->clientMailCopiesID[$keyMail]->comment;
            }
            $clientPhonesDellID = array_keys(array_diff_key($clientCopy[$keyClient]->clientPhoneCopiesID, $modelClient->clientPhonesID));
            foreach ($clientPhonesDellID as $clientPhoneDellID) {
                $change->phone[$clientPhoneDellID] = ['phone' => false, 'comment' => false];
            }
            foreach ($modelClient->clientPhonesID as $keyPhone => $mClientPhone) {
                $change->phone[$keyPhone]['phone'] = $mClientPhone->phone === $clientCopy[$keyClient]->clientPhoneCopiesID[$keyPhone]->phone;
                $change->phone[$keyPhone]['comment'] = $mClientPhone->comment === $clientCopy[$keyClient]->clientPhoneCopiesID[$keyPhone]->comment;
            }

            $clientContactsDellID = array_keys(array_diff_key($clientCopy[$keyClient]->clientContactCopiesID, $modelClient->clientContactsID));

            foreach ($clientContactsDellID as $clientContactDellID) {
                $change->contact[$clientContactDellID] = ['name' => false, 'main' => false, 'position' => false];
                foreach ($clientCopy[$keyClient]->clientContactCopiesID[$clientContactDellID]->clientContactPhoneCopiesID as $contactPhone) {
                    $change->contact[$clientContactDellID]['phone'][$contactPhone->id] = ['phone' => false, 'comment' => false, 'notedit' => false];
                }
                foreach ($clientCopy[$keyClient]->clientContactCopiesID[$clientContactDellID]->clientContactMailCopiesID as $contactMail) {
                    $change->contact[$clientContactDellID]['mail'][$contactMail->id] = ['address' => false, 'comment' => false, 'notedit' => false];
                }
            }

            foreach ($modelClient->clientContactsID as $keyContact => $mClientContact) {
                $change->contact[$keyContact]['name'] = $mClientContact->name === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->name;
                $change->contact[$keyContact]['main'] = $mClientContact->main === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->main;
                $change->contact[$keyContact]['position'] = $mClientContact->position === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->position;

                $contactPhonesCopy = $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactPhoneCopiesID;
                $contactPhones = $mClientContact->clientContactPhonesID;
                if (is_array($contactPhonesCopy) && is_array($contactPhones)){
                    $clientContactPhonesDellID = array_keys(array_diff_key($contactPhonesCopy, $contactPhones));
                    foreach ($clientContactPhonesDellID as $clientContactPhoneDellID) {
                        $change->contact[$keyContact]['phone'][$clientContactPhoneDellID] = ['notedit' => false];
                    }
                }

                foreach ($mClientContact->clientContactPhonesID as $keyCPhone => $mClientContactPhone) {
                    $change->contact[$keyContact]['phone'][$keyCPhone]['phone'] = $mClientContactPhone->phone === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactPhoneCopiesID[$keyCPhone]->phone;
                    $change->contact[$keyContact]['phone'][$keyCPhone]['comment'] = $mClientContactPhone->comment === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactPhoneCopiesID[$keyCPhone]->comment;
                    $change->contact[$keyContact]['phone'][$keyCPhone]['notedit'] = array_search(false, $change->contact[$keyContact]['phone'][$keyCPhone]) === false;
                }
                $change->contact[$keyContact]['phone_notedit'] = !count(array_filter($change->contact[$keyContact]['phone'], function ($a) {return !$a['notedit'];}));

                $contactMailsCopy = $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactMailCopiesID;
                $contactMails = $mClientContact->clientContactMailsID;
                if (is_array($contactMailsCopy) && is_array($contactMails)){
                    $clientContactMailsDellID = array_keys(array_diff_key($contactMailsCopy, $contactMails));
                    foreach ($clientContactMailsDellID as $clientContactMailDellID) {
                        $change->contact[$keyContact]['mail'][$clientContactMailDellID] = ['notedit' => false];
                    }
                }

                foreach ($mClientContact->clientContactMailsID as $keyCMail => $mClientContactMail) {
                    $change->contact[$keyContact]['mail'][$keyCMail]['address'] = $mClientContactMail->address === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactMailCopiesID[$keyCMail]->address;
                    $change->contact[$keyContact]['mail'][$keyCMail]['comment'] = $mClientContactMail->comment === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactMailCopiesID[$keyCMail]->comment;
                    $change->contact[$keyContact]['mail'][$keyCMail]['notedit'] = array_search(false, $change->contact[$keyContact]['mail'][$keyCMail]) === false;
                }
                $change->contact[$keyContact]['mail_notedit'] = !count(array_filter($change->contact[$keyContact]['mail'], function ($a) {return !$a['notedit'];}));
                $change->contact[$keyContact]['notedit'] = $change->contact[$keyContact]['name']
                    && $change->contact[$keyContact]['main']
                    && $change->contact[$keyContact]['position']
                    && $change->contact[$keyContact]['phone_notedit']
                    && $change->contact[$keyContact]['mail_notedit'];
            }
            $change->contacts = count(array_filter($change->contact, function ($a) {return !$a['notedit'];}));
            foreach ($modelClient->clientAddressesID as $keyAddress => $mClientAddress) {
                $change->address[$keyAddress]['country'] = $mClientAddress->country === $clientCopy[$keyClient]->clientAddressCopiesID[$keyAddress]->country;
                $change->address[$keyAddress]['region'] = $mClientAddress->region === $clientCopy[$keyClient]->clientAddressCopiesID[$keyAddress]->region;
                $change->address[$keyAddress]['city'] = $mClientAddress->city === $clientCopy[$keyClient]->clientAddressCopiesID[$keyAddress]->city;
                $change->address[$keyAddress]['street'] = $mClientAddress->street === $clientCopy[$keyClient]->clientAddressCopiesID[$keyAddress]->street;
                $change->address[$keyAddress]['home'] = $mClientAddress->home === $clientCopy[$keyClient]->clientAddressCopiesID[$keyAddress]->home;
                $change->address[$keyAddress]['comment'] = $mClientAddress->comment === $clientCopy[$keyClient]->clientAddressCopiesID[$keyAddress]->comment;
                $change->address[$keyAddress]['note'] = $mClientAddress->note === $clientCopy[$keyClient]->clientAddressCopiesID[$keyAddress]->note;
                $change->address[$keyAddress]['notedit'] = array_search(false, $change->address[$keyAddress]) === false;
            }
            $changes[$keyClient] = $change;
        }

        return $this->render('index', [
            'searchModel' => $clientEditSearch,
            'pages' => $dataProvider->getPagination(),
            'modelsUser' =>  User::find()->all(),
            'changes' => $changes ?: [],
            'modelsClient' => $modelsClient,
            'mCopy' => $clientCopy,
        ]);
    }

    public function actionCopy(int $id)
    {
        try {
            if (Client::findOne($id)) {
                $this->clientCopyService->backup($id);
                return true;
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            echo $e->getMessage();
            return false;
        }
    }

    public function actionRecovery(int $id)
    {
        try {
            if ($model = ClientCopy::findOne($id)) {
                $this->clientCopyService->recovery($id);
                return true;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            Yii::$app->session->setFlash('error', $e->getMessage());
            return false;
        }
    }

    public function actionApprove_reject(int $id)
    {
        try {
            $this->clientCopyService->approve_reject($id);
            return $this->redirect(['function/check_reject']);
        } catch (\Exception $e) {
            echo $e->getMessage();
            Yii::$app->session->setFlash('error', $e->getMessage());
            return false;
        }
    }

    public function actionCancel_reject(int $id)
    {
        try {
            $this->clientCopyService->cancel_reject($id);
            return $this->redirect(['function/check_reject']);
        } catch (\Exception $e) {
            echo $e->getMessage();
            Yii::$app->session->setFlash('error', $e->getMessage());
            return false;
        }
    }

    public function actionChoose()
    {
        if ($ids = Yii::$app->request->post('Client')['id']) {
            foreach ($ids as $id => $checked) {
                if ($checked) {
                    if (Yii::$app->request->post('recovery')) {
                        $this->clientCopyService->recovery($id);
                    }
                    if (Yii::$app->request->post('backup')) {
                        $this->clientCopyService->backup($id);
                    }
                    if (Yii::$app->request->post('cancelreject')) {
                        $this->clientCopyService->cancel_reject($id);
                    }
                    if (Yii::$app->request->post('approvereject')) {
                        $this->clientCopyService->approve_reject($id);
                    }
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCheck_reject()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->joinWith('clientReject');
        $dataProvider->query->andWhere(['status' => Client::STATUS_REJECT, 'approved' => 0]);
        return $this->render('checkreject', [
            'searchModel' => $searchModel,
            'modelsUser' =>  User::find()->all(),
            'dataProvider' => $dataProvider,
            'models' => $dataProvider->getModels(),
        ]);
    }

    public function backupClientRest()
    {
        $modelsID = Client::find()->select('id')->where(['not in', 'id', ClientCopy::find()->select('id')])->all();
        foreach ($modelsID as $modelID) {
            $this->clientCopyService->backup($modelID->id);
        }
    }
}
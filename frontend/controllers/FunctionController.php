<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\services\client\ClientCopyService;
use common\models\User;
use common\models\Client;
use common\models\ClientCopy;
use app\models\ClientEditSearch;
use yii\data\Pagination;

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

        $queryClient = Client::find()->select('client.id')->indexBy('id')
            ->leftJoin('client_copy', Client::tableName() . '.`id` = ' . ClientCopy::tableName() .'.`id`')
            ->where(ClientCopy::tableName() . '.`update` <> ' . Client::tableName() . '.`update`');
        $countClients = clone $queryClient;
        $pages = new Pagination(['totalCount' => $countClients->count(), 'pageSize' => 1]);
        $pages->pageSizeParam = false;
        $modelsClient = $queryClient->offset($pages->offset)->limit($pages->limit)->all();

        foreach ($modelsClient as $keyClient => $modelClient) {
            $change = new \stdClass;
            $change->name = $modelClient->name === $clientCopy[$keyClient]->name;
            foreach ($modelClient->clientJursID as $keyJur => $mClientJur) {
                $change->jur[$keyJur] = $mClientJur->name === $clientCopy[$keyClient]->clientJurCopiesID[$keyJur]->name;
            }
            foreach ($modelClient->clientMailsID as $keyMail => $mClientMail) {
                $change->mail[$keyMail]['address'] = $mClientMail->address === $clientCopy[$keyClient]->clientMailCopiesID[$keyMail]->address;
                $change->mail[$keyMail]['comment'] = $mClientMail->comment === $clientCopy[$keyClient]->clientMailCopiesID[$keyMail]->comment;
            }
            foreach ($modelClient->clientPhonesID as $keyPhone => $mClientPhone) {
                $change->phone[$keyPhone]['phone'] = $mClientPhone->phone === $clientCopy[$keyClient]->clientPhoneCopiesID[$keyPhone]->phone;
                $change->phone[$keyPhone]['comment'] = $mClientPhone->comment === $clientCopy[$keyClient]->clientPhoneCopiesID[$keyPhone]->comment;
            }
            foreach ($modelClient->clientContactsID as $keyContact => $mClientContact) {
                $change->contact[$keyContact]['name'] = $mClientContact->name === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->name;
                $change->contact[$keyContact]['main'] = $mClientContact->main === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->main;
                $change->contact[$keyContact]['position'] = $mClientContact->position === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->position;
                foreach ($mClientContact->clientContactPhonesID as $keyCPhone => $mClientContactPhone) {
                    $change->contact[$keyContact]['phone'][$keyCPhone]['phone'] = $mClientContactPhone->phone === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactPhoneCopiesID[$keyCPhone]->phone;
                    $change->contact[$keyContact]['phone'][$keyCPhone]['comment'] = $mClientContactPhone->comment === $clientCopy[$keyClient]->clientContactCopiesID[$keyContact]->clientContactPhoneCopiesID[$keyCPhone]->comment;
                    $change->contact[$keyContact]['phone'][$keyCPhone]['notedit'] = array_search(false, $change->contact[$keyContact]['phone'][$keyCPhone]) === false;
                }
                $change->contact[$keyContact]['phone_notedit'] = !count(array_filter($change->contact[$keyContact]['phone'], function ($a) {return !$a['notedit'];}));
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
        //$dataProvider = $clientEditSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $clientEditSearch,
            //'dataProvider' => $dataProvider,
            'modelsUser' =>  User::find()->all(),
            'changes' => $changes ?: [],
            'modelsClient' => $modelsClient,
            'mCopy' => $clientCopy,
            'pages' => $pages,
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

    public function backupClientRest()
    {
        $modelsID = Client::find()->select('id')->where(['not in', 'id', ClientCopy::find()->select('id')])->all();
        foreach ($modelsID as $modelID) {
            $this->clientCopyService->backup($modelID->id);
        }
    }
}
<?php

namespace frontend\services\client;

use common\models\Client;
use common\models\ClientCopy;
use common\models\ClientJurCopy;
use common\models\ClientPhoneCopy;
use common\models\ClientMailCopy;
use common\models\ClientContactCopy;
use common\models\ClientContactPhoneCopy;
use common\models\ClientContactMailCopy;
use common\models\ClientAddressCopy;

Class ClientCopyService
{
    public function backup($id)
    {
        $model = Client::findOne($id);
        $modelOldCopy = ClientCopy::findOne($id);

        $transaction = \Yii::$app->db->beginTransaction();

        if ($modelOldCopy && !$modelOldCopy->delete()) {
            throw new \RuntimeException('Delete error in table ' . ClientCopy::tableName() . '.');
        }

        $modelCopy = ClientCopy::create(
            $model->id,
            $model->user_id,
            $model->user_add_id,
            $model->name,
            $model->anchor,
            $model->update
        );

        if ($modelCopy->save(false)) {
            foreach ($model->clientJurs as $modelClientJur) {
                $clientJurCopies = ClientJurCopy::create(
                    $modelClientJur->id,
                    $modelClientJur->client_id,
                    $modelClientJur->name
                );
                if (!$clientJurCopies->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientJurCopy::tableName() . '.');
                    $transaction->rollBack();
                }
            }
            foreach ($model->clientPhones as $modelClientPhone) {
                $clientPhoneCopies = ClientPhoneCopy::create(
                    $modelClientPhone->id,
                    $modelClientPhone->client_id,
                    $modelClientPhone->phone,
                    $modelClientPhone->country,
                    $modelClientPhone->city,
                    $modelClientPhone->number,
                    $modelClientPhone->comment
                );
                if (!$clientPhoneCopies->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientPhoneCopy::tableName() . '.');
                    $transaction->rollBack();
                }
            }
            foreach ($model->clientMails as $modelClientMail) {
                $clientMailCopies = ClientMailCopy::create(
                    $modelClientMail->id,
                    $modelClientMail->client_id,
                    $modelClientMail->address,
                    $modelClientMail->comment
                );
                if (!$clientMailCopies->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientMailCopy::tableName() . '.');
                    $transaction->rollBack();
                }
            }
            foreach ($model->clientContacts as $modelClientContact) {
                $clientContactCopies = ClientContactCopy::create(
                    $modelClientContact->id,
                    $modelClientContact->client_id,
                    $modelClientContact->name,
                    $modelClientContact->main,
                    $modelClientContact->position
                );
                if (!$clientContactCopies->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientContactCopy::tableName() . '.');
                    $transaction->rollBack();
                }
                foreach ($modelClientContact->clientContactPhones as $mClientContactPhone) {
                    $clientContactPhoneCopies = ClientContactPhoneCopy::create(
                        $mClientContactPhone->id,
                        $mClientContactPhone->contact_id,
                        $mClientContactPhone->phone,
                        $mClientContactPhone->country,
                        $mClientContactPhone->city,
                        $mClientContactPhone->number,
                        $mClientContactPhone->comment
                    );
                    if (!$clientContactPhoneCopies->save(false)) {
                        throw new \RuntimeException('Save error in table ' . ClientContactPhoneCopy::tableName() . '.');
                        $transaction->rollBack();
                    }
                }
                foreach ($modelClientContact->clientContactMails as $mClientContactMail) {
                    $clientContactMailCopies = ClientContactMailCopy::create(
                        $mClientContactMail->id,
                        $mClientContactMail->contact_id,
                        $mClientContactMail->address,
                        $mClientContactMail->comment
                    );
                    if (!$clientContactMailCopies->save(false)) {
                        throw new \RuntimeException('Save error in table ' . ClientContactMailCopy::tableName() . '.');
                        $transaction->rollBack();
                    }
                }
            }
            foreach ($model->clientAddresses as $mClientAddress) {
                $clientAddressCopies = ClientAddressCopy::create($mClientAddress->id, $mClientAddress->client_id, $mClientAddress->country, $mClientAddress->region, $mClientAddress->city, $mClientAddress->street, $mClientAddress->home, $mClientAddress->comment, $mClientAddress->note);
                if (!$clientAddressCopies->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientAddressCopy::tableName() . '.');
                    $transaction->rollBack();
                }
            }
            $transaction->commit();
        }

    }

    public static function recovery(int $id)
    {
        $modelCopy = ClientCopy::findOne($id);
        $modelOldOriginal = Client::findOne($id);

        $transaction = \Yii::$app->db->beginTransaction();

        if ($modelOldOriginal && !$modelOldOriginal->delete()) {
            throw new \RuntimeException('Delete error in table ' . Client::tableName() . '.');
        }

        $model = Client::create(
            $modelCopy->id,
            $modelCopy->user_id,
            $modelCopy->user_add_id,
            $modelCopy->name,
            $modelCopy->anchor,
            $modelCopy->update
        );
        if ($model->save(false)) {
            foreach ($modelCopy->clientJurCopies as $modelClientJurCopy) {
                $modelJur = ClientJur::create(
                    $modelClientJurCopy->id,
                    $modelClientJurCopy->client_id,
                    $modelClientJurCopy->name
                );
                if (!$modelJur->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientJur::tableName() . '.');
                    $transaction->rollBack();
                }
            }
            foreach ($modelCopy->clientPhoneCopies as $modelClientPhoneCopy) {
                $modelPhone = ClientPhone::create(
                    $modelClientPhoneCopy->id,
                    $modelClientPhoneCopy->client_id,
                    $modelClientPhoneCopy->phone,
                    $modelClientPhoneCopy->country,
                    $modelClientPhoneCopy->city,
                    $modelClientPhoneCopy->number,
                    $modelClientPhoneCopy->comment
                );
                if (!$modelPhone->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientPhone::tableName() . '.');
                    $transaction->rollBack();
                }
            }
            foreach ($modelCopy->clientMailCopies as $modelClientMailCopy) {
                $modelMail = ClientMail::create(
                    $modelClientMailCopy->id,
                    $modelClientMailCopy->client_id,
                    $modelClientMailCopy->address,
                    $modelClientMailCopy->comment
                );
                if (!$modelMail->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientMail::tableName() . '.');
                    $transaction->rollBack();
                }
            }
            foreach ($modelCopy->clientContactCopies as $modelClientContactCopy) {
                $modelContact = ClientContact::create($modelClientContactCopy->id, $modelClientContactCopy->client_id, $modelClientContactCopy->name, $modelClientContactCopy->main, $modelClientContactCopy->position);
                if (!$modelContact->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientContact::tableName() . '.');
                    $transaction->rollBack();
                }
                foreach ($modelClientContactCopy->clientContactPhoneCopies as $mClientContactPhoneCopy) {
                    $clientContactPhone = ClientContactPhone::create(
                        $mClientContactPhoneCopy->id,
                        $mClientContactPhoneCopy->contact_id,
                        $mClientContactPhoneCopy->phone,
                        $mClientContactPhoneCopy->country,
                        $mClientContactPhoneCopy->city,
                        $mClientContactPhoneCopy->number,
                        $mClientContactPhoneCopy->comment
                    );
                    if (!$clientContactPhone->save(false)) {
                        throw new \RuntimeException('Save error in table ' . ClientContactPhone::tableName() . '.');
                        $transaction->rollBack();
                    }
                }
                foreach ($modelClientContactCopy->clientContactMailCopies as $mClientContactMailCopy) {
                    $clientContactMail = ClientContactMail::create(
                        $mClientContactMailCopy->id,
                        $mClientContactMailCopy->contact_id,
                        $mClientContactMailCopy->address,
                        $mClientContactMailCopy->comment
                    );
                    if (!$clientContactMail->save(false)) {
                        throw new \RuntimeException('Save error in table ' . ClientContactMail::tableName() . '.');
                        $transaction->rollBack();
                    }
                }
            }
            foreach ($modelCopy->clientAddressCopies as $mClientAddressCopy) {
                $clientAddress = ClientAddress::create(
                    $mClientAddressCopy->id,
                    $mClientAddressCopy->client_id,
                    $mClientAddressCopy->country,
                    $mClientAddressCopy->region,
                    $mClientAddressCopy->city,
                    $mClientAddressCopy->street,
                    $mClientAddressCopy->home,
                    $mClientAddressCopy->comment,
                    $mClientAddressCopy->note
                );
                if (!$clientAddress->save(false)) {
                    throw new \RuntimeException('Save error in table ' . ClientAddress::tableName() . '.');
                    $transaction->rollBack();
                }
            }
        }
        $transaction->commit();
    }
}
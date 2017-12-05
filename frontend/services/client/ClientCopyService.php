<?php

namespace frontend\services\client;

use common\models\Client;
use common\models\ClientAddress;
use common\models\ClientContact;
use common\models\ClientContactMail;
use common\models\ClientContactPhone;
use common\models\ClientCopy;
use common\models\ClientJur;
use common\models\ClientJurCopy;
use common\models\ClientMail;
use common\models\ClientPhone;
use common\models\ClientPhoneCopy;
use common\models\ClientMailCopy;
use common\models\ClientContactCopy;
use common\models\ClientContactPhoneCopy;
use common\models\ClientContactMailCopy;
use common\models\ClientAddressCopy;
use app\base\Model;
use yii\helpers\ArrayHelper;

Class ClientCopyService
{
    public function backup($id)
    {
        $model = Client::findOne($id);
        $modelOldCopy = ClientCopy::findOne($id);
        $transaction = \Yii::$app->db->beginTransaction();

        $modelCopy = ClientCopy::create(
            $model->id,
            $model->user_id,
            $model->user_add_id,
            $model->name,
            $model->anchor,
            $model->showed_at,
            $model->updated_at,
            $model->status
        );
        try {
            if (isset($modelOldCopy)) {
                $modelOldCopy->delete();
            }
            if ($flag = $modelCopy->save(false)) {
                foreach ($model->clientJurs as $modelClientJur) {
                    $clientJurCopies = ClientJurCopy::create(
                        $modelClientJur->id,
                        $modelClientJur->client_id,
                        $modelClientJur->name
                    );
                    if (! ($flag = $clientJurCopies->save(false))) {
                        throw new \RuntimeException('Save error in table ' . ClientJurCopy::tableName() . '.');
                        $transaction->rollBack();
                        break;
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
                    if (! ($flag = $clientPhoneCopies->save(false))) {
                        throw new \RuntimeException('Save error in table ' . ClientPhoneCopy::tableName() . '.');
                        $transaction->rollBack();
                        break;
                    }
                }
                foreach ($model->clientMails as $modelClientMail) {
                    $clientMailCopies = ClientMailCopy::create(
                        $modelClientMail->id,
                        $modelClientMail->client_id,
                        $modelClientMail->address,
                        $modelClientMail->comment
                    );
                    if (! ($flag = $clientMailCopies->save(false))) {
                        throw new \RuntimeException('Save error in table ' . ClientMailCopy::tableName() . '.');
                        $transaction->rollBack();
                        break;
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
                    if (! ($flag = $clientContactCopies->save(false))) {
                        throw new \RuntimeException('Save error in table ' . ClientContactCopy::tableName() . '.');
                        $transaction->rollBack();
                        break;
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
                        if (! ($flag = $clientContactPhoneCopies->save(false))) {
                            throw new \RuntimeException('Save error in table ' . ClientContactPhoneCopy::tableName() . '.');
                            $transaction->rollBack();
                            break;
                        }
                    }
                    foreach ($modelClientContact->clientContactMails as $mClientContactMail) {
                        $clientContactMailCopies = ClientContactMailCopy::create(
                            $mClientContactMail->id,
                            $mClientContactMail->contact_id,
                            $mClientContactMail->address,
                            $mClientContactMail->comment
                        );
                        if (! ($flag = $clientContactMailCopies->save(false))) {
                            throw new \RuntimeException('Save error in table ' . ClientContactMailCopy::tableName() . '.');
                            $transaction->rollBack();
                            break;
                        }
                    }
                }
                foreach ($model->clientAddresses as $mClientAddress) {
                    $clientAddressCopies = ClientAddressCopy::create($mClientAddress->id, $mClientAddress->client_id, $mClientAddress->country, $mClientAddress->region, $mClientAddress->city, $mClientAddress->street, $mClientAddress->home, $mClientAddress->comment, $mClientAddress->note);
                    if (! ($flag = $clientAddressCopies->save(false))) {
                        throw new \RuntimeException('Save error in table ' . ClientAddressCopy::tableName() . '.');
                        $transaction->rollBack();
                        break;
                    }
                }
            }
            if ($flag) {
                $transaction->commit();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }

    public static function recovery(int $id)
    {
        $clientCopy = ClientCopy::findOne($id);
        $jursCopy = $clientCopy->clientJurCopiesID;
        $phonesCopy = $clientCopy->clientPhoneCopiesID;
        $mailsCopy = $clientCopy->clientMailCopiesID;
        $contactsCopy = $clientCopy->clientContactCopiesID;
        $addressesCopy = $clientCopy->clientAddressCopiesID;
        $client = Client::findOne($id);
        $jurs = $client->clientJursID;
        $phones = $client->clientPhonesID;
        $mails = $client->clientMailsID;
        $contacts = $client->clientContactsID;
        $addresses = $client->clientAddressesID;
        $modelsClientContactPhone = [];
        $oldPhones = [];
        $modelsClientContactMail = [];
        $oldMails = [];

        if (!empty($contacts)) {
            foreach ($contacts as $indexContact => $modelClientContact) {
                $contactPhones = ClientContactPhone::loadMultipleCopy($modelClientContact->clientContactPhonesID, $contactsCopy[$indexContact]->clientContactPhoneCopiesID);
                $modelsClientContactPhone[$indexContact] = $contactPhones;
                $oldPhones = ArrayHelper::merge(ArrayHelper::index($contactPhones, 'id'), $oldPhones);

                $contactMails = ClientContactMail::loadMultipleCopy($modelClientContact->clientContactMailsID, $contactsCopy[$indexContact]->clientContactMailCopiesID);
                $modelsClientContactMail[$indexContact] = $contactMails;
                $oldMails = ArrayHelper::merge(ArrayHelper::index($contactMails, 'id'), $oldMails);
            }
        }

        if ($client = Client::loadMultipleCopy($client, $clientCopy)) {

            $oldIDsJur = ArrayHelper::map($jurs, 'id', 'id');
            $oldIDsPhone = ArrayHelper::map($phones, 'id', 'id');
            $oldIDsMail = ArrayHelper::map($mails, 'id', 'id');
            $oldIDsContact = ArrayHelper::map($contacts, 'id', 'id');
            $oldIDsAddress = ArrayHelper::map($addresses, 'id', 'id');

            #loadMultiple
            $jurs = ClientJur::loadMultipleCopy($jurs, $jursCopy);
            $phones = ClientPhone::loadMultipleCopy($phones, $phonesCopy);
            $mails = ClientMail::loadMultipleCopy($mails, $mailsCopy);
            $contacts = ClientContact::loadMultipleCopy($contacts, $contactsCopy);
            $addresses = ClientAddress::loadMultipleCopy($addresses, $addressesCopy);

            $deletedIDsJur = array_diff($oldIDsJur, array_filter(ArrayHelper::map($jursCopy, 'id', 'id')));
            $deletedIDsPhone = array_diff($oldIDsPhone, array_filter(ArrayHelper::map($phonesCopy, 'id', 'id')));
            $deletedIDsMail = array_diff($oldIDsMail, array_filter(ArrayHelper::map($mailsCopy, 'id', 'id')));
            $deletedIDsContact = array_diff($oldIDsContact, array_filter(ArrayHelper::map($contactsCopy, 'id', 'id')));
            $deletedIDsAddress = array_diff($oldIDsAddress, array_filter(ArrayHelper::map($addressesCopy, 'id', 'id')));

            //validate all models
            $valid = $client->validate();
            $valid = Model::validateMultiple($jurs) && $valid;
            $valid = Model::validateMultiple($phones) && $valid;
            $valid = Model::validateMultiple($mails) && $valid;
            $valid = Model::validateMultiple($contacts) && $valid;
            $valid = Model::validateMultiple($addresses) && $valid;

            $phonesIDs = [];
            $mailsIDs = [];

            if (!empty($contactsCopy)) {
                foreach ($contactsCopy as $indexContact => $contactCopy) {
                    $contactPhones = $contactCopy->clientContactPhoneCopiesID;
                    $phonesIDs = ArrayHelper::merge($phonesIDs, array_filter(ArrayHelper::getColumn($contactPhones, 'id')));
                    foreach ($contactPhones as $indexContactPhone => $contactPhone) {
                        $contactPhone = (!empty($contactPhone['id']) && !empty($oldPhones[$contactPhone['id']])) ? $oldPhones[$contactPhone['id']] : ClientContactPhone::create(
                            $contactPhone->id,
                            $contactPhone->phone,
                            $contactPhone->country,
                            $contactPhone->city,
                            $contactPhone->number,
                            $contactPhone->comment
                        );
                        $modelsClientContactPhone[$indexContact][$indexContactPhone] = $contactPhone;
                        $valid = $valid && $contactPhone->validate();
                    }
                    $contactMails = $contactCopy->clientContactMailCopiesID;
                    $mailsIDs = ArrayHelper::merge($mailsIDs, array_filter(ArrayHelper::getColumn($contactMails, 'id')));
                    foreach ($contactMails as $indexContactMail => $contactMail) {
                        $contactMail = (!empty($contactMail['id']) && !empty($oldMails[$contactMail['id']])) ? $oldMails[$contactMail['id']] : ClientContactMail::create(
                            $contactMail->id,
                            $contactMail->address,
                            $contactMail->comment
                        );
                        $modelsClientContactMail[$indexContact][$indexContactMail] = $contactMail;
                        $valid = $valid && $contactMail->validate();
                    }
                }
            }
            $oldIDsClientContactPhone = ArrayHelper::getColumn($oldPhones, 'id');
            $deletedIDsContactPhone = array_diff($oldIDsClientContactPhone, $phonesIDs);

            $oldIDsClientContactMail = ArrayHelper::getColumn($oldMails, 'id');
            $deletedIDsContactMail = array_diff($oldIDsClientContactMail, $mailsIDs);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $client->save(false)) {
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
                        foreach ($jurs as $jur) {
                            if (! ($flag = $jur->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($phones as $phone) {
                            if (! ($flag = $phone->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($mails as $mail) {
                            if (! ($flag = $mail->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($contacts as $indexContact => $contact) {
                            if (! ($flag = $contact->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            if (isset($modelsClientContactPhone[$indexContact]) && is_array($modelsClientContactPhone[$indexContact])) {
                                foreach ($modelsClientContactPhone[$indexContact] as $contactPhone) {
                                    $contactPhone->contact_id = $indexContact;
                                    if (! ($flag = $contactPhone->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                }
                            }
                            if (isset($modelsClientContactMail[$indexContact]) && is_array($modelsClientContactMail[$indexContact])) {
                                foreach ($modelsClientContactMail[$indexContact] as $contactMail) {
                                    $contactMail->contact_id = $indexContact;
                                    if (! ($flag = $contactMail->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                }
                            }
                        }
                        foreach ($addresses as $address) {
                            if (! ($flag = $address->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        }
    }
}
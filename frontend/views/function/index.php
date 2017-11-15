<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use frontend\assets\FunctionAsset;



/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientEditSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

FunctionAsset::register($this);
$this->title = 'Функции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>
    <div colswr="1">
        <div colcont clearfix>
            <div dop-menu>
                <?= Menu::widget([
                    'items' => [
                        ['label' => 'Проверка изменений', 'url' => ['function/index']],
                        ['label' => 'Проверка отказов', 'url' => ['function/reject']],
                        ['label' => 'Передача клиентов', 'url' => ['function/transfer']],
                        ['label' => 'Дополнительный доступ', 'url' => ['function/addaccess']],
                    ],
                    'activeCssClass' => 'cur',
                    'options' => [
                        'cust-dop-menu' => '',
                    ]
                ])?>
            </div>
            <div filters>
                <?php echo $this->render('_search', [
                    'model' => $searchModel,
                    'modelsUser' => $modelsUser,
                    'changes' => $changes,
                ]); ?>
            </div>
            <div cards>
                <div check-all>
                    <input type="checkbox" class="checkbox" id="checkbox-all" />
                    <label for="checkbox-all">Выбрать все</label>
                </div>
                <? foreach ($changes as $id => $change) {?>
                    <div smallcard function>
                        <div check>
                            <input type="checkbox" class="checkbox" id="checkbox-<?= Html::encode($id)?>" />
                            <label for="checkbox-<?= Html::encode($id)?>"></label>
                        </div>
                        <p><?= Html::a($modelsClient[$id]->name, ['client/view', 'id' => $id], ['size20' => ''])?>, Саратов<br />ООО "Роса"</p>
                        <div changes>
                            <a href="#">
                                <h3>Было:</h3>
                                <? foreach ($change->jur as $kJur => $jur) {
                                    if (!$jur) {
                                        echo '<p><span gray size14>Полное название юр. лица</span><br />'
                                            .Html::encode($mCopy[$id]->clientJurCopiesID[$kJur]->name).'</p>';
                                    }
                                }?>
                                <? foreach ($change->mail as $kMail => $mail) {
                                    if (!$mail['address'] || !$mail['comment']) {
                                        echo '<p><span gray size14>E-mail</span><br />'
                                            . Html::encode($mCopy[$id]->clientMailCopiesID[$kMail]->address . ' ' . $mCopy[$id]->clientMailCopiesID[$kMail]->comment) . '</p>';
                                    }
                                }?>
                                <? foreach ($change->phone as $kPhone => $phone) {
                                    if (!$phone['phone'] || !$phone['comment']) {
                                        echo '<p><span gray size14>Телефон</span><br />'
                                            . Html::encode($mCopy[$id]->clientPhoneCopiesID[$kPhone]->country . ' ' . $mCopy[$id]->clientPhoneCopiesID[$kPhone]->city . ' ' . $mCopy[$id]->clientPhoneCopiesID[$kPhone]->number . ' ' . $mCopy[$id]->clientPhoneCopiesID[$kPhone]->comment) . '</p>';
                                    }
                                }?>
                                <? foreach ($change->contact as $kContact => $contact) {
                                    if (!$contact['name'] || !$contact['main'] || !$contact['position'] || !$contact['notedit']) {
                                        echo '<p><span gray size14>Контактные лица</span><br />'
                                            . Html::encode($mCopy[$id]->clientContactCopiesID[$kContact]->name) . ': ' . $mCopy[$id]->clientContactCopiesID[$kContact]->position . '</p>';
                                        foreach ($mCopy[$id]->clientContactCopiesID[$kContact]->clientContactPhoneCopiesID as $kCPhone => $phone) {
                                            echo (!$contact['phone'][$kCPhone]['notedit']) ? '<p>' . Html::encode($phone['country'] . ' ' . $phone['city'] . ' ' . $phone['number'] . ' ' . $phone['comment']) . '</p>' : '';
                                        }
                                        foreach ($mCopy[$id]->clientContactCopiesID[$kContact]->clientContactMailCopiesID as $kCMail => $mail) {
                                            echo (!$contact['mail'][$kCMail]['notedit']) ? '<p>' . Html::encode($mail['address'] . ' ' . $mail['comment']) . '</p>' : '';
                                        }
                                    }
                                }?>
                                <? foreach ($change->address as $kAddress => $address) {
                                    if (!$address['notedit']) {
                                        echo '<p><span gray size14>Адрес</span><br />'
                                            . Html::encode($mCopy[$id]->clientAddressCopiesID[$kAddress]->country
                                                . ' ' . $mCopy[$id]->clientAddressCopiesID[$kAddress]->region
                                                . ' ' . $mCopy[$id]->clientAddressCopiesID[$kAddress]->city
                                                . ' ' . $mCopy[$id]->clientAddressCopiesID[$kAddress]->street
                                                . ' ' . $mCopy[$id]->clientAddressCopiesID[$kAddress]->home
                                                . ' ' . $mCopy[$id]->clientAddressCopiesID[$kAddress]->comment
                                                . ' ' . $mCopy[$id]->clientAddressCopiesID[$kAddress]->note) . '</p>';
                                    }
                                }?>
                                <span class="recovery" input="<?=Yii::$app->urlManager->createUrl(['function/recovery', 'id' => $id])?>">Вернуть</span>
                            </a>
                        </div>
                        <div changes>
                            <a href="#">
                                <h3>Стало:</h3>
                                <? foreach ($change->jur as $kJur => $jur) {
                                    if (!$jur) {
                                        echo '<p><span gray size14>Полное название юр. лица</span><br />'
                                            . Html::encode($modelsClient[$id]->clientJursID[$kJur]->name) . '</p>';
                                    }
                                }?>
                                <? foreach ($change->mail as $kMail => $mail) {
                                    if (!$mail['address'] || !$mail['comment']) {
                                        echo '<p><span gray size14>E-mail</span><br />'
                                            . Html::encode($modelsClient[$id]->clientMailsID[$kMail]->address . ' ' . $modelsClient[$id]->clientMailsID[$kMail]->comment) . '</p>';
                                    }
                                }?>
                                <? foreach ($change->phone as $kPhone => $phone) {
                                    if (!$phone['phone'] || !$phone['comment']) {
                                        echo '<p><span gray size14>Телефон</span><br />'
                                            . Html::encode($modelsClient[$id]->clientPhonesID[$kPhone]->country . ' ' . $modelsClient[$id]->clientPhonesID[$kPhone]->city . ' ' . $modelsClient[$id]->clientPhonesID[$kPhone]->number . ' ' . $modelsClient[$id]->clientPhonesID[$kPhone]->comment) . '</p>';
                                    }
                                }?>
                                <? foreach ($change->contact as $kContact => $contact) {
                                    if (!$contact['name'] || !$contact['main'] || !$contact['position'] || !$contact['notedit']) {
                                        echo '<p><span gray size14>Контактные лица</span><br />'
                                            . Html::encode($modelsClient[$id]->clientContactsID[$kContact]->name) . ' ' . $modelsClient[$id]->clientContactsID[$kContact]->position . '</p>';
                                        foreach ($modelsClient[$id]->clientContactsID[$kContact]->clientContactPhonesID as $kCPhone => $phone) {
                                            echo (!$contact['phone'][$kCPhone]['notedit']) ? '<p>' . Html::encode($phone['country'] . ' ' . $phone['city'] . ' ' . $phone['number'] . ' ' . $phone['comment']) . '</p>' : '';
                                        }
                                        foreach ($modelsClient[$id]->clientContactsID[$kContact]->clientContactMailsID as $kCMail => $mail) {
                                            echo (!$contact['mail'][$kCMail]['notedit']) ? '<p>' . Html::encode($mail['address'] . ' ' . $mail['comment']) . '</p>' : '';
                                        }
                                    }
                                }?>
                                <? foreach ($change->address as $kAddress => $address) {
                                    if (!$address['notedit']) {
                                        echo '<p><span gray size14>Адрес</span><br />'
                                            . Html::encode($modelsClient[$id]->clientAddressesID[$kAddress]->country
                                                . ' ' . $modelsClient[$id]->clientAddressesID[$kAddress]->region
                                                . ' ' . $modelsClient[$id]->clientAddressesID[$kAddress]->city
                                                . ' ' . $modelsClient[$id]->clientAddressesID[$kAddress]->street
                                                . ' ' . $modelsClient[$id]->clientAddressesID[$kAddress]->home
                                                . ' ' . $modelsClient[$id]->clientAddressesID[$kAddress]->comment
                                                . ' ' . $modelsClient[$id]->clientAddressesID[$kAddress]->note) . '</p>';
                                    }
                                }?>
                                <span class="copy" input="<?=Yii::$app->urlManager->createUrl(['function/copy', 'id' => $id])?>">Принять</span>
                            </a>
                        </div>
                        <p size14><span gray>Изменено:</span> 24.10.2016<br />
                            <span gray>Последнее открытие:</span> 4 дня назад</p>
                        <p><span size14 gray>Менеджер:</span> Кириллов Н. Н.</p>
                    </div>
                <?}?>
                <div pages>
                    <p><a scroll href="#"><<</a><a scroll href="#"><</a><a cur href="#">1</a><a href="#">2</a><a href="#">3</a><span>...</span><a href="#">9</a><a href="#">10</a><a scroll href="#">></a><a scroll href="#">>></a></p>
                </div>
            </div>
            <div bot-fixed clearfix func-footer><div><input type="submit" value="Вернуть выбранное" /> <input fl-right type="submit" value="Принять выбранное" /></div></div>
        </div>
    </div>
</div>
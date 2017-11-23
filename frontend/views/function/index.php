<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;

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
            <?php $form = ActiveForm::begin(['action' => ['function/choose'], 'id' => 'contact-form', 'options' => ['cards' => '']]); ?>
                <div check-all>
                    <input type="checkbox" class="checkbox" id="checkbox-all" />
                    <label for="checkbox-all">Выбрать все</label>
                </div>
                <? foreach ($changes as $id => $change) {?>
                    <div smallcard function>
                        <?= $form->field($mCopy[$id], 'id[' . $id . ']', ['options' => ['tag' => false]])->checkbox(
                                [
                                    'template' => '<div check>{input}<label for="{label}"></label></div>',
                                    'label' => 'checkbox-' . Html::encode($id),
                                    'id' => 'checkbox-' . Html::encode($id),
                                    'class' => 'checkbox',
                                    'value' => '1',
                                ]) ?>
                        <p><?= Html::a($modelsClient[$id]->name, ['client/view', 'id' => $id], ['size20' => ''])?>, <?=($modelsClient[$id]->clientAddresses[0]->city) ?: '' ?><br /><?=($modelsClient[$id]->clientJurs[0]->name) ?: ''?></p>
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
                        <p size14><span gray>Изменено:</span> <?= Html::encode(\DateTime::createFromFormat('Y-m-d H:i:s', $modelsClient[$id]->updated_at)->format('d.m.Y'))?><br />
                            <span gray>Последнее открытие:</span> <?= Html::encode(\DateTime::createFromFormat('Y-m-d H:i:s', $modelsClient[$id]->showed_at)->format('d.m.Y'))?></p>
                        <p><span size14 gray>Менеджер:</span> <?=$modelsClient[$id]->user->name1?></p>
                    </div>
                <?}?>

                <?
                echo LinkPager::widget([
                        'pagination' => $pages,
                ])?>
                <div bot-fixed clearfix func-footer><div><?= Html::submitInput('Вернуть выбранное', ['name' => 'recovery'])?><?= Html::submitInput('Принять выбранное', ['name' => 'backup', 'fl-right' => ''])?></div></div>
            <?php ActiveForm::end();?>
        </div>
    </div>
</div>
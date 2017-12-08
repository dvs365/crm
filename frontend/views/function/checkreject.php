<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;

use frontend\assets\FunctionAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

FunctionAsset::register($this);
$this->title = 'Функции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>
            <div colswr="1">
                <div colcont clearfix>
                    <div dop-menu>
                        <?php echo $this->render('_menu'); ?>
                    </div>
                    <div filters>
                        <?php echo $this->render('_search', [
                            'model' => $searchModel,
                            'modelsUser' => $modelsUser,
                        ]); ?>
                    </div>
                    <?php $form = ActiveForm::begin(['action' => ['function/choose'], 'id' => 'contact-form', 'options' => ['cards' => '']]); ?>
                        <div check-all>
                            <input type="checkbox" class="checkbox" id="checkbox-all" />
                            <label for="checkbox-all">Выбрать все</label>
                        </div>
                        <? foreach ($models as $model) {?>
                            <div smallcard function>
                                <!--<div check><input type="checkbox" class="checkbox" id="checkbox-' . $model->id . '"><label for="checkbox-' . $model->id . '"></label></div>-->
                                <?= $form->field($model, 'id[' . $model->id . ']', ['options' => ['tag' => false]])->checkbox(
                                    [
                                        'template' => '<div check>{input}<label for="{label}"></label></div>',
                                        'label' => 'checkbox-' . Html::encode($model->id),
                                        'id' => 'checkbox-' . Html::encode($model->id),
                                        'class' => 'checkbox',
                                        'value' => '1',
                                    ]);?>
                                <p><?= Html::a($model->name, ['client/view', 'id' => $model->id], ['size20' => ''])?>
                                <?= (!empty($model->clientAddresses[0]->city) ? ', ' . Html::encode(implode(', ', array_unique(ArrayHelper::map($model->clientAddresses, 'id', 'city')))) : '') . '<br />'?>
                                <?= !empty($model->clientJurs[0]->name) ? Html::encode(implode(', ', ArrayHelper::map($model->clientJurs, 'id', 'name'))) . '</p>' : ''?>
                                <div refusals><p><span gray size14>Дата переноса:</span><br /><?= Html::encode(\DateTime::createFromFormat('Y-m-d H:i:s', $model->clientReject->created_at)->format('d.m.Y'))?></p>
                                    <p><span gray size14>Причина переноса:</span><br /><?= Html::encode($model->clientReject->reason)?>&nbsp;</p>
                                    <?= Html::a('Отменить', ['function/cancel_reject', 'id' => $model->id], ['class' => 'a-submit']) . Html::a('Принять', ['function/approve_reject', 'id' => $model->id], ['class' => 'a-submit'])?>
                                </div>
                                <?= ($model->user->name1)? '<p><span size14 gray>Менеджер:</span> ' . Html::encode($model->user->name1.' '.mb_substr($model->user->name2, 0, 1, 'utf-8').'. '.mb_substr($model->user->name3, 0, 1, 'utf-8').'.') . '</p>' : ''?>
                            </div>
                        <?}?>
                        <div bot-fixed clearfix func-footer><div><?= Html::submitInput('Отменить выбранное', ['name' => 'cancelreject'])?><?= Html::submitInput('Принять выбранное', ['name' => 'approvereject', 'fl-right' => ''])?></div></div>
                    <?php ActiveForm::end();?>
                </div>
            </div>
        </div>

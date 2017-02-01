
<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>
    <?= Menu::widget([
        'items' => [
            ['label' => 'Все', 'url' => ['/client/index']],
            ['label' => 'Создать', 'url' => ['/client/create']],
            ['label' => 'Свободные', 'url' => ['/client/free']],
            ['label' => 'Потенциальные', 'url' => ['/client/possible']],
            ['label' => 'Рабочие', 'url' => ['/client/worker']],
            ['label' => 'Отказные', 'url' => ['/client/reject']],
            ['label' => 'Статистика', 'url' => ['/client/statistic'], 'visible' => Yii::$app->user->can('moder')],
        ],
        'activeCssClass' => 'cur',
        'options' => [
            'cust-dop-menu-horizontal' => '',
        ]
    ])?>
    <h1><?= Html::encode($this->title) ?> <span>&#9875</span></h1>
    <div cust-content>
        <div col1>
            <div cust-inf-block>
                <div class="expand-link-com-inf" tit inf>Общая информация <span up>&#9652</span><span down>&#9662</span></div>
                <div class="expand-block-com-inf"><?= Html::a('Редастировать', ['update', 'id' => $model->id], ['cust-edit' => '', 'size14' => ''])?>
                    <span expand-link-movetorefused cust-edit size14>Перенести в отказные</span>
                    <form expand-block-movetorefused>
                        <textarea title="Причина переноса" placeholder="Укажите причину переноса"></textarea>
                        <input type="submit" value="Перенести" />
                    </form>
                    <? if ($model->clientJurs[0]->name) {?>
                    <p><span size14>Юр. лицо:</span><br />
                        <? foreach ($model->clientJurs as $indexClientJur => $clientJur) {
                            if (!$clientJur->name) continue;
                            echo ($indexClientJur) ? '<br /><span size14 gray>'.$clientJur->name.'</span>' : '<span size14>'.$clientJur->name.'</span>';
                        }?>
                    </p>
                    <?}?>
                    <p><?= $model->clientContacts[0]->name?> <u comment><?= $model->clientContacts[0]->position?></u>
                        <? if ($model->clientContacts[1]->name) {?>
                            <br /><span gray><?= $model->clientContacts[1]->name?> <u comment><?= $model->clientContacts[1]->position?></u></span>
                        <?}?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
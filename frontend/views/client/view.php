<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <? echo '<pre>'; print_r($modelsClientJur[1]->name); echo '</pre>'; die(); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'name',
            'value' => function ($model) {
                return $model->getClientJurs();
            }
        ],
    ]) ?>
    <? foreach ($modelsClientJur as $modelClientJur) {?>
        <?= DetailView::widget([
            'model' => $modelClientJur,
            'attributes' => [
                'id',
                'client_id',
                'name',
            ],
        ]) ?>
    <?}?>


</div>

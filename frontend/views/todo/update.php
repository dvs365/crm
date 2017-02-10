<?php

use yii\helpers\Html;
use frontend\assets\TodoAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Todo */

TodoAsset::register($this);

$this->title = 'Редактировать дело';
$this->params['breadcrumbs'][] = ['label' => 'Todos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div workarea>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
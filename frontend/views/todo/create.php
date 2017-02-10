<?php

use yii\helpers\Html;
use frontend\assets\TodoAsset;

TodoAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\Todo */

$this->title = 'Добавить дело';
$this->params['breadcrumbs'][] = ['label' => 'Todos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\assets\TodoAsset;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TodoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

TodoAsset::register($this);
$this->title = 'Todos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="todo-index">

	<h1><?= Html::encode($this->title) ?></h1>
	<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

	<p>
		<?= Html::a('Create Todo', ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id',
			'client_id',
			'name',
			'time_from',
			'time_to',
			// 'repeat',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
</div>
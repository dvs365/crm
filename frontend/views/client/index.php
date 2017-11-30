<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>
	<div colswr="1">
		<div colcont clearfix>
			<div dop-menu>
				<?= Menu::widget([
					'items' => [
						['label' => 'Все', 'url' => ['/client/index']],
						['label' => 'Создать', 'url' => ['/client/create']],
						['label' => 'Свободные', 'url' => ['client/free']],
						['label' => 'Потенциальные', 'url' => ['/client/target']],
						['label' => 'Рабочие', 'url' => ['/client/load']],
						['label' => 'Отказные', 'url' => ['/client/reject']],
						['label' => 'Статистика', 'url' => ['/client/statistic'], 'visible' => Yii::$app->user->can('moder')],
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
				]); ?>
			</div>
			<div cards>
			<?= ListView::widget([
				'dataProvider' => $dataProvider,
                'summary' => '',
                'pager' => [
                    'firstPageLabel' => '<<',
                    'lastPageLabel' => '>>',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'maxButtonCount' => 3,
                ],
				'itemOptions' => ['smallcard' => ''],
				'itemView' => function ($model, $key, $index, $widget) {
                    $template = '<span size20 lnk>' . Html::encode($model->name) . '</span>';
                    $template .= (!empty($model->clientAddresses[0]->city) ? ', ' . Html::encode(implode(', ', array_unique(ArrayHelper::map($model->clientAddresses, 'id', 'city')))) : '') . '<br />';
                    $template .= !empty($model->clientJurs[0]->name) ? Html::encode(implode(', ', ArrayHelper::map($model->clientJurs, 'id', 'name'))) . '<br />' : '';
                    $template .= '<span size14 gray>Последнее открытие: ' . Html::encode($model->agoTime) . '</span><br />';
                    $template .= ($model->user->name1)? '<span size14>Менеджер: ' . Html::encode($model->user->name1.' '.mb_substr($model->user->name2, 0, 1, 'utf-8').'. '.mb_substr($model->user->name3, 0, 1, 'utf-8').'.') . '</span><br />' : '';
                    $template .= '<span size14>Статус:</span> <span size14 ' . $model->statusColor . '>' . $model->statusLabel . '</span>';
                    return $model->isReject ? '<div class="reject">' . $template . '</div>' : Html::a($template, ['view', 'id' => $model->id]);
				},
			]) ?>
			</div>
		</div>
	</div>
</div>
<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\grid\GridView;
use frontend\assets\TodoAsset;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TodoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

TodoAsset::register($this);
$this->title = 'Todos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>
	<div colswr="1">
		<div colcont clearfix>
			<div period>
				<p size14>Сегодня:<br /><span size24>14.10.2016</span></p>
				<form><label>Дела на дату:</label><input name="date" type="text" id="date" value=""></form>
				<?= Menu::widget([
					'items' => [
						['label' => 'День', 'url' => ['/todo/index']],
						['label' => 'Неделя', 'url' => ['/todo/create']],
						['label' => 'Месяц', 'url' => ['/todo/free']],
					],
					'activeCssClass' => 'cur',
					'options' => [
						//'tag' => false,
					],
					//'itemOptions' => ['tag' => false],
				])?>
				<?= Html::a('Новое', ['todo/create'], ['new' => ''])?>
			</div>
			<div filters>
				<form search-form do>
					<div search-field><input type="text" name="search" id="search" /><input type="submit" value="Найти" /></div>
					<p><?= Html::a('Звонок', 'javascript:void(0)', ['not-link' => ''])?><?= Html::a('Письмо', 'javascript:void(0)', ['not-link' => ''])?><?= Html::a('Счет', 'javascript:void(0)', ['not-link' => ''])?></p>
				</form>
			</div>
			<div cards>
				<p important><?= Html::a('Важные', 'javascript:void(0)', ['not-link' => ''])?><?= Html::a('Текущие', 'javascript:void(0)', ['not-link' => ''])?><?= Html::a('Просроченные', 'javascript:void(0)', ['not-link' => ''])?></p>
				<div missed>
					<table>
						<tr>
							<td><input type="checkbox"></td>
							<td><span flag>&#127986; </span></td>
							<td>Флекси</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>10:00</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td></td>
							<td>ИП Иванова</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>16:30</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td></td>
							<td>ОПТ Анкор</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>12:00</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td><span flag>&#127986; </span></td>
							<td>ОПТ Анкор</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>10:00</td>
						</tr>
					</table>
				</div>
				<div current>
					<table>
						<tr>
							<td><input type="checkbox"></td>
							<td><span flag>&#127986; </span></td>
							<td>Флекси</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>10:00</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td></td>
							<td>Флекси</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>16:30</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td></td>
							<td>Флекси</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>12:00</td>
						</tr>
						<tr>
							<td><input type="checkbox"></td>
							<td><span flag>&#127986; </span></td>
							<td>Флекси</td>
							<th><a href="#">Название дела</a></th>
							<td>07.10.16</td>
							<td>10:00</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php //echo $this->render('_search', ['model' => $searchModel]); ?>

	<!--<p>
		<?= Html::a('Create Todo', ['create'], ['class' => 'btn btn-success']) ?>
	</p>-->
	<?/*= GridView::widget([
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
	]);*/ ?>
</div>
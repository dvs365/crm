<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;
use frontend\assets\TodoAsset;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\TodoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

setlocale(LC_TIME, "ru_RU.UTF-8");
TodoAsset::register($this);
$this->title = 'Todos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>
	<div colswr="1">
		<div colcont clearfix>
			<div period>
				<p size14>Сегодня:<br /><span size24><?=date('d.m.Y',time())?></span></p>
				<?= Html::beginForm(['todo/month'], 'post')?>
				<label>Дела на дату:</label>
				<?= Html::input('text', 'date', Yii::$app->request->post('date'), ['id' => 'date', 'onchange' => 'this.form.submit()'])?>
				<?= Html::endForm()?>
				<?= Menu::widget([
					'items' => [
						['label' => 'День', 'url' => ['/todo/day']],
						['label' => 'Неделя', 'url' => ['/todo/week']],
						['label' => 'Месяц', 'url' => ['/todo/month']],
					],
					'activeCssClass' => 'cur',
				])?>
				<?= Html::a('Новое', ['todo/create'], ['new' => ''])?>
			</div>
			<div cards>
				<? foreach ($month as $num => $tr) {?>
                    <u h2><?= strftime("%B", strtotime($num.'/01/'. date('Y')))?></u>
					<div month>
						<table>
							<tr>
								<td>ПН</td>
								<td>ВТ</td>
								<td>СР</td>
								<td>ЧТ</td>
								<td>ПТ</td>
								<td>СБ</td>
								<td>ВС</td>
							</tr>
                            <? $resetTr = reset($tr); $endTr = end($tr);?>
							<? foreach ($tr as $td) {?>
                                <tr>
									<?= ($td === $resetTr) ? str_repeat("<td></td>", 7-count($td)) : ''?>
                                    <? foreach ($td as $day) {?>
                                        <td <?= (($day['date']->format('d.m.Y') === date('d.m.Y')) ? 'today' : '')?>><?= Html::a($day['date']->format('j').(($day['count']) ? '<span>'.$day['count'].'</span>' : ''), ['todo/day'], [
												'data' => [
													'method' => 'post',
													'params' => [
														'date' => $day['date']->format('d.m.Y'),
													]
												]])?></td>
                                    <?}?>
									<?= ($td === $endTr) ? str_repeat("<td></td>", 7-count($td)) : ''?>
								</tr>
							<?}?>
						</table>
					</div>
				<?}?>
			</div>
		</div>
	</div>
</div>
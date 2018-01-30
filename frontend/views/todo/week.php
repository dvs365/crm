<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\ListView;
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
                <p size14>Сегодня:<br /><span size24><?=date('d.m.Y',time())?></span></p>
                <?= Html::beginForm(['todo/week'], 'post')?>
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
                <div week>
                    <table>
                        <?foreach ($models as $weekDay => $model) {
                            foreach($model as $num => $todo) {
                                $tr[$num][$weekDay] = $todo;
                            }
                        }?>
                        <tr>
                            <td today><?= Html::a($week[1] . ', ' . $day[1]->format('d.m'), ['todo/day'], [
                                    'data' => [
                                            'method' => 'post',
                                            'params' => [
                                                    'date' => $day[1]->format('d.m.Y'),
                                            ]
                                    ]
                                ])?></td>
                            <td><?= Html::a($week[2] . ', ' . $day[2]->format('d.m'), ['todo/day'], [
									'data' => [
										'method' => 'post',
										'params' => [
											'date' => $day[2]->format('d.m.Y'),
										]
									]
								])?></td>
                            <td><?= Html::a($week[3] . ', ' . $day[3]->format('d.m'), ['todo/day'], [
									'data' => [
										'method' => 'post',
										'params' => [
											'date' => $day[3]->format('d.m.Y'),
										]
									]
								])?></td>
                            <td><?= Html::a($week[4] . ', ' . $day[4]->format('d.m'), ['todo/day'], [
									'data' => [
										'method' => 'post',
										'params' => [
											'date' => $day[4]->format('d.m.Y'),
										]
									]
								])?></td>
                            <td><?= Html::a($week[5] . ', ' . $day[5]->format('d.m'), ['todo/day'], [
									'data' => [
										'method' => 'post',
										'params' => [
											'date' => $day[5]->format('d.m.Y'),
										]
									]
								])?></td>
                            <td><?= Html::a($week[6] . ', ' . $day[6]->format('d.m'), ['todo/day'], [
									'data' => [
										'method' => 'post',
										'params' => [
											'date' => $day[6]->format('d.m.Y'),
										]
									]
								])?></td>
                            <td><?= Html::a($week[7] . ', ' . $day[7]->format('d.m'), ['todo/day'], [
									'data' => [
										'method' => 'post',
										'params' => [
											'date' => $day[7]->format('d.m.Y'),
										]
									]
								])?></td>
                        </tr>
                        <?
                        if ($tr) {
                            foreach ($tr as $todo) {?>
                                <tr class="num">
                                    <? for ($i = 1; $i <=7; $i++) {?>
                                       <? if ($todo[$i] && $todo[$i]->repeat == $todo[$i]::REPEAT_DAY) {
                                            $datetime1 = new DateTime($todo[$i]->time_from);
                                            $datetime2 = new DateTime($todo[$i]->time_to);
											$datetime3 = new DateTime($day[$i]->format('d.m.Y'));
											$interval = $datetime1->diff($datetime2);
									    	$current = $datetime3->diff($datetime1);
                                        }?>
                                    <td><?=($todo[$i]) ? Html::a($todo[$i]->name.(($todo[$i]->repeat == $todo[$i]::REPEAT_DAY) ? ' <span long>'.(($current->format('%a'))+1).'/'.(($interval->format('%a'))+1).'</span>':''), ['todo/update', 'id' => $todo[$i]->id]) : '' ?></td>
                                <?}?>
                            </tr>
                            <?}?>
                        <?}?>
                    </table>
                </div>
            </div>
</div>
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
                <?= Html::beginForm(['todo/day'], 'post')?>
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
            <div filters>
                <form search-form do>
                    <div search-field><input type="text" name="search" id="search" /><input type="submit" value="Найти" /></div>
                    <p><?= Html::a('Звонок', 'javascript:void(0)', ['not-link' => ''])?><?= Html::a('Письмо', 'javascript:void(0)', ['not-link' => ''])?><?= Html::a('Счет', 'javascript:void(0)', ['not-link' => ''])?></p>
                </form>
            </div>
            <div cards>
                <p important><?= Html::a('Важные', 'javascript:void(0)', ['not-link' => '', 'id' => 'client'])?><?= Html::a('Текущие', 'javascript:void(0)', ['not-link' => '', 'id' => 'current'])?><?= Html::a('Просроченные', 'javascript:void(0)', ['not-link' => '', 'id' => 'missed'])?></p>
                <div all>
                    <table>
						<? $date = \DateTime::createFromFormat('d.m.Y H:i', (Yii::$app->request->post('date')) ?  Yii::$app->request->post('date').' 00:00' : date('d.m.Y H:i'))?>
                        <? foreach ($models as $model) {?>
							<? if ($model->repeat == 'dayly') {
                                $datetime1 = new DateTime($model->time_from);
                                $datetime2 = new DateTime($model->time_to);
                                $datetime3 = min($datetime2, new DateTime(Yii::$app->request->post('date')));
                                $interval = $datetime1->diff($datetime2);
                                $current = $datetime3->diff($datetime1);
                            }?>
                            <tr <?= (($model->client->name) ? 'client ' : '') . (($model->time_to < $date->format('Y-m-d H:i')) ? 'missed' : 'current')?>>
                                <td><input type="checkbox"></td>
                                <td><span class="flag">&#127986; </span></td>
                                <td><?= Html::encode($model->client->name) ?></td>
                                <th><?= Html::a($model->name, ['todo/update', 'id' => $model->id]).(($model->repeat == 'dayly') ? ' <span long>'.(($current->format('%a'))+1).'/'.(($interval->format('%a'))+1) : '')?></th>
                                <td><?= \DateTime::createFromFormat('Y-m-d H:i:s', $model->time_to)->format('d.m.y')?></td>
                                <td><?= \DateTime::createFromFormat('Y-m-d H:i:s', $model->time_to)->format('H:i')?></td>
                            </tr>
                        <?}?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
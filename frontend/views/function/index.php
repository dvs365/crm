<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Функции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>
    <div colswr="1">
        <div colcont clearfix>
            <div dop-menu>
                <?= Menu::widget([
                    'items' => [
                        ['label' => 'Проверка изменений', 'url' => ['function/index']],
                        ['label' => 'Проверка отказов', 'url' => ['function/reject']],
                        ['label' => 'Передача клиентов', 'url' => ['function/transfer']],
                        ['label' => 'Дополнительный доступ', 'url' => ['function/addaccess']],
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
                    'itemOptions' => ['smallcard' => ''],
                    'itemView' => function ($model, $key, $index, $widget) {
                        $template = '<span size20 lnk>' . Html::encode($model->name) . '</span><br />';
                        $template .= '<span size14 gray>Последнее открытие: ' . Html::encode($model->agoTime) . '</span><br />';
                        $template .= '<span size14>Менеджер: ' . Html::encode($model->user->name1.' '.mb_substr($model->user->name2, 0, 1, 'utf-8').'. '.mb_substr($model->user->name3, 0, 1, 'utf-8')). '.</span><br />';
                        $template .= '<span size14>Статус:</span>';
                        $template .= '<span size14>' . Html::encode(Yii::$app->session->getFlash('error')) . '</span>';
                        return Html::a($template, ['client/view', 'id' => $model->id]);
                    },
                ]) ?>
            </div>
        </div>
    </div>
</div>
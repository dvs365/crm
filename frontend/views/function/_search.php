<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
        'search-form' => ''
    ]
]); ?>
<div search-field>
    <?= $form->field($model, 'clientSearch', ['options' => ['class' => ''], 'template' => "{input}"])->textInput(['id' => 'search', 'class' => '']) ?>
    <? $items = ArrayHelper::map($modelsUser, 'id', 'fullFio'); $items[8] = '';?>
    <?= (Yii::$app->user->can('moder')) ? $form->field($model, 'user_id', ['options' => ['class' => 'client_field'], 'template' => "{input}"])->dropDownList($items, ['class' => '', 'id' =>'manager', 'prompt' => 'Все менеджеры'])->label(false) : ''?>
    <?= Html::submitInput('Найти')?>
    <?= $form->field($model, 'anchor', ['options' => ['class' => 'client_field'], 'template' => "{input}"])->checkbox(['title' => 'Основное контактное лицо'], false)?>
</div>
<?php ActiveForm::end(); ?>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */

?>
<?php	DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper_address', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items_address', // required: css class selector
	'widgetItem' => '.item_address', // required: css class
	'limit' => 10, // the maximum times, an element can be cloned (default 999)
	'min' => 1, // 0 or 1 (default 1)
	'insertButton' => '.add-item_address', // css class
	'deleteButton' => '.remove-item_address', // css class
	'model' => $modelsClientAddress[0],
	'formId' => 'dynamic-form',
	'formFields' => [
		'country',
		'region',
		'city',
		'street',
		'home',
		'comment',
		'note',
	],
]);
?>
	<div class="container-items_address">
		<?php foreach ($modelsClientAddress as $indexAddress => $modelClientAddress): ?>
			<div class="item_address">
				<div num>
					<?php
					//necessary for update action.
					if (! $modelClientAddress->isNewRecord) {
						echo Html::activeHiddenInput($modelClientAddress, "[{$indexAddress}]id");
					}
					?>
					<?= $form->field($modelClientAddress, "[{$indexAddress}]country", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Страна', 'placeholder' => 'Страна']) ?>
					<?= $form->field($modelClientAddress, "[{$indexAddress}]region", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Регион', 'placeholder' => 'Регион']) ?>
					<?= $form->field($modelClientAddress, "[{$indexAddress}]city", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Город', 'placeholder' => 'Город']) ?>
					<?= $form->field($modelClientAddress, "[{$indexAddress}]street", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Улица', 'placeholder' => 'Улица']) ?>
					<?= $form->field($modelClientAddress, "[{$indexAddress}]home", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Дом/корпус/офис', 'placeholder' => 'Дом/корпус/офис']) ?>
					<?= $form->field($modelClientAddress, "[{$indexAddress}]comment", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий']) ?>
					<?= (Yii::$app->user->can('moder')) ? $form->field($modelClientAddress, "[{$indexAddress}]note", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'note' => '', 'title' => 'Заметка суперпользователя', 'placeholder' => 'Заметка суперпользователя']) : '' ?>
					<p class="expand-link"><?= Html::a('Отобразить на карте', 'javascript:void(0);', ['cust-add' => ''])?></p>
					<div class="expand-block">ЯНДЕК-КАРТА!!! УРА!!!!!</div>
				</div>
				<p add-adress><?= Html::a('Удалить адрес', '#', ['class' => 'remove-item_address', 'title' => 'Удалить', 'cust-add' => ''])?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<p add-adress><?= Html::a('Добавить адрес', '#', ['class' => 'add-item_address', 'title' => 'Добавить', 'cust-add' => ''])?></p>
<?php DynamicFormWidget::end(); ?>
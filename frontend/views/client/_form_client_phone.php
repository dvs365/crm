<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */

?>
<?php	DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper_client_phone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items_client_phone', // required: css class selector
	'widgetItem' => '.item_client_phone', // required: css class
	'limit' => 10, // the maximum times, an element can be cloned (default 999)
	'min' => 1, // 0 or 1 (default 1)
	'insertButton' => '.add-item_client_phone', // css class
	'deleteButton' => '.remove-item_client_phone', // css class
	'model' => $modelsClientPhone[0],
	'formId' => 'dynamic-form',
	'formFields' => [
		'country',
		'city',
		'number',
		'comment'
	],
]);
?>
<p>Телефон:</p>
<div class="container-items_client_phone">
	<?php foreach ($modelsClientPhone as $index => $modelClientPhone): ?>
		<div class="item_client_phone">
			<u>
				<?php
				//necessary for update action.
				if (! $modelClientPhone->isNewRecord) {
					echo Html::activeHiddenInput($modelClientPhone, "[{$index}]id");
				}
				?>
				<?= $form->field($modelClientPhone, "[{$index}]country", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'country' => '', 'title' => 'Код страны', 'placeholder' => '+7']) ?>
				<?= $form->field($modelClientPhone, "[{$index}]city", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'city' => '', 'title' => 'Код города/оператора', 'placeholder' => '919']) ?>
				<?= $form->field($modelClientPhone, "[{$index}]number", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'number' => '', 'title' => 'Номер', 'placeholder' => '456-45-45']) ?>
				<?= $form->field($modelClientPhone, "[{$index}]comment", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'phone-comment' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий']) ?>
				<a add-jur class="remove-item_client_phone" title="Удалить"><span add>-</span></a>
			</u>
		</div>
	<?php endforeach; ?>
</div>
<a add-jur class="add-item_client_phone" title="Добавить"><span add>&#10011</span></a>
<?php DynamicFormWidget::end(); ?>

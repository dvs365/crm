<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

?>
<?php	DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper_client_contact_phone', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items_client_contact_phone', // required: css class selector
	'widgetItem' => '.item_client_contact_phone', // required: css class
	'limit' => 10, // the maximum times, an element can be cloned (default 999)
	'min' => 1, // 0 or 1 (default 1)
	'insertButton' => '.add-item_client_contact_phone', // css class
	'deleteButton' => '.remove-item_client_contact_phone', // css class
	'model' => $modelsClientContactPhone[0],
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
<div class="container-items_client_contact_phone">
	<?php foreach ($modelsClientContactPhone as $indexPhone => $modelClientContactPhone): ?>
		<div class="item_client_contact_phone">
			<u phoneremove>
				<?php
				//necessary for update action.
				if (! $modelClientContactPhone->isNewRecord) {
					echo Html::activeHiddenInput($modelClientContactPhone, "[{$indexContact}][{$indexPhone}]id");
				}
				?>
				<?= $form->field($modelClientContactPhone, "[{$indexContact}][{$indexPhone}]country", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'country' => '', 'title' => 'Код страны', 'placeholder' => '+7']) ?>
				<?= $form->field($modelClientContactPhone, "[{$indexContact}][{$indexPhone}]city", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'city' => '', 'title' => 'Код города/оператора', 'placeholder' => '919']) ?>
				<?= $form->field($modelClientContactPhone, "[{$indexContact}][{$indexPhone}]number", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'number' => '', 'title' => 'Номер', 'placeholder' => '456-45-45']) ?>
				<?= $form->field($modelClientContactPhone, "[{$indexContact}][{$indexPhone}]comment", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'phone-comment' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий']) ?>
				<?= Html::a('<span del></span>', '#', ['class' => 'remove-item_client_contact_phone', 'title' => 'Удалить'])?>
			</u>
		</div>
	<?php endforeach; ?>
</div>
<?= Html::a('<span add></span>', '#', ['class' => 'add-item_client_contact_phone', 'title' => 'Добавить'])?>
<?php DynamicFormWidget::end(); ?>

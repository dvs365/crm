<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */

?>
<?php	DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper_contact', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items_contact', // required: css class selector
	'widgetItem' => '.item_contact', // required: css class
	'limit' => 10, // the maximum times, an element can be cloned (default 999)
	'min' => 1, // 0 or 1 (default 1)
	'insertButton' => '.add-item_contact', // css class
	'deleteButton' => '.remove-item_contact', // css class
	'model' => $modelsClientContact[0],
	'formId' => 'dynamic-form',
	'formFields' => [
		'name',
		'main',
		'position',
	],
]);
?>
<div tit>Контактные лица:</div>
<div class="container-items_contact">
	<?php foreach ($modelsClientContact as $index => $modelClientContact): ?>
		<div class="item_contact">
			<div num>
				<?php
				//necessary for update action.
				if (! $modelClientContact->isNewRecord) {
					echo Html::activeHiddenInput($modelClientContact, "[{$index}]id");
				}
				?>
				<?= $form->field($modelClientContact, "[{$index}]name", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'ФИО', 'placeholder' => 'ФИО']) ?>
				<?= $form->field($modelClientContact, "[{$index}]main", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->checkbox(['title' => 'Основное контактное лицо'], false)?>
				<?= $form->field($modelClientContact, "[{$index}]position", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Должность', 'placeholder' => 'Должность']) ?>
			</div>
			<p add-contact><a class="remove-item_contact" title="Удалить" cust-add>Удалить контактное лицо</a></p>
		</div>
	<?php endforeach; ?>
</div>
<p add-contact><a class="add-item_contact" title="Добавить" cust-add>Добавить контактное лицо</a></p>

<?php DynamicFormWidget::end(); ?>

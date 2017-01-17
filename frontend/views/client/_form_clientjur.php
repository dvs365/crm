<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */

?>
<?php	DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items', // required: css class selector
	'widgetItem' => '.item', // required: css class
	'limit' => 10, // the maximum times, an element can be cloned (default 999)
	'min' => 1, // 0 or 1 (default 1)
	'insertButton' => '.add-item', // css class
	'deleteButton' => '.remove-item', // css class
	'model' => $modelsClientJur[0],
	'formId' => 'dynamic-form',
	'formFields' => [
		'name',
	],
]);
?>
<div class="container-items">
	<?php foreach ($modelsClientJur as $index => $modelClientJur): ?>
		<div class="item">
			<?php
			//necessary for update action.
			if (! $modelClientJur->isNewRecord) {
				echo Html::activeHiddenInput($modelClientJur, "[{$index}]id");
			}
			?>
			<?= $form->field($modelClientJur, "[{$index}]name", ['options' => ['class' => 'client_field'], 'template' => "{error}{input}<a del-jur class=\"remove-item\" title=\"Удалить\"><span del>-</span></a>"])->textInput(['maxlength' => true, 'class' => '', 'title' => 'Юр. лицо', 'placeholder' => 'Полное название юр. лица']) ?>
		</div>
	<?php endforeach; ?>
</div>
<a add-jur class="add-item" title="Добавить"><span add>&#10011</span></a>
<?php DynamicFormWidget::end(); ?>

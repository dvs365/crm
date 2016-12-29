<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Address: " + (index + 1))
    });
});
';

$this->registerJs($js);

?>
<?php

DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items', // required: css class selector
	'widgetItem' => '.item', // required: css class
	'limit' => 4, // the maximum times, an element can be cloned (default 999)
	'min' => 0, // 0 or 1 (default 1)
	'insertButton' => '.add-item', // css class
	'deleteButton' => '.remove-item', // css class
	'model' => $modelsClientJur[0],
	'formId' => 'dynamic-form',
	'formFields' => [
		'name',
	],
]);

 ?>
<?php foreach ($modelsClientJur as $index => $modelClientJur): ?>
	<?php
		//necessary for update action.
		if (! $modelClientJur->isNewRecord) {
			echo Html::activeHiddenInput($modelClientJur, "[{$index}]id");
		}
	?>
	<?= $form->field($modelClientJur, "[{$index}]name")->textInput(['maxlength' => true]) ?>
<?php endforeach; ?>
<?php DynamicFormWidget::end(); ?>

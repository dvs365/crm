<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */

?>
<?php	DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper_client_mail', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items_client_mail', // required: css class selector
	'widgetItem' => '.item_client_mail', // required: css class
	'limit' => 10, // the maximum times, an element can be cloned (default 999)
	'min' => 1, // 0 or 1 (default 1)
	'insertButton' => '.add-item_client_mail', // css class
	'deleteButton' => '.remove-item_client_mail', // css class
	'model' => $modelsClientMail[0],
	'formId' => 'dynamic-form',
	'formFields' => [
		'address',
		'comment'
	],
]);
?>
<p>E-mail:</p>
<div class="container-items_client_mail">
	<?php foreach ($modelsClientMail as $index => $modelClientMail): ?>
		<div class="item_client_mail">
			<u>
				<?php
				//necessary for update action.
				if (! $modelClientMail->isNewRecord) {
					echo Html::activeHiddenInput($modelClientMail, "[{$index}]id");
				}
				?>
				<?= $form->field($modelClientMail, "[{$index}]address", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'E-mail' => '', 'title' => 'E-mail', 'placeholder' => 'E-mail']) ?>
				<?= $form->field($modelClientMail, "[{$index}]comment", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'mail-comment' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий']) ?>
				<?= Html::a('<span del></span>', '#', ['class' => 'remove-item_client_mail', 'title' => 'Удалить'])?>
			</u>
		</div>
	<?php endforeach; ?>
</div>
<?= Html::a('<span add></span>', '#', ['class' => 'add-item_client_mail', 'title' => 'Добавить'])?>
<?php DynamicFormWidget::end(); ?>

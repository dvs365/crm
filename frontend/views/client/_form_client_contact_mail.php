<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

?>
<?php	DynamicFormWidget::begin([
	'widgetContainer' => 'dynamicform_wrapper_client_contact_mail', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
	'widgetBody' => '.container-items_client_contact_mail', // required: css class selector
	'widgetItem' => '.item_client_contact_mail', // required: css class
	'limit' => 10, // the maximum times, an element can be cloned (default 999)
	'min' => 1, // 0 or 1 (default 1)
	'insertButton' => '.add-item_client_contact_mail', // css class
	'deleteButton' => '.remove-item_client_contact_mail', // css class
	'model' => $modelsClientContactMail[0],
	'formId' => 'dynamic-form',
	'formFields' => [
		'address',
		'comment'
	],
]);
?>
<p>E-mail:</p>
<div class="container-items_client_contact_mail">
	<?php foreach ($modelsClientContactMail as $indexMail => $modelClientContactMail): ?>
		<div class="item_client_contact_mail">
			<u mailremove>
				<?php
				//necessary for update action.
				if (! $modelClientContactMail->isNewRecord) {
					echo Html::activeHiddenInput($modelClientContactMail, "[{$indexContact}][{$indexMail}]id");
				}
				?>
				<?= $form->field($modelClientContactMail, "[{$indexContact}][{$indexMail}]address", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'E-mail' => '', 'title' => 'E-mail', 'placeholder' => 'E-mail']) ?>
				<?= $form->field($modelClientContactMail, "[{$indexContact}][{$indexMail}]comment", ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'class' => '', 'mail-comment' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий']) ?>
				<a class="remove-item_client_contact_mail" title="Удалить"><span del></span></a>
			</u>
		</div>
	<?php endforeach; ?>
</div>
<a add-mail1 class="add-item_client_contact_mail" title="Добавить"><span add></span></a>
<?php DynamicFormWidget::end(); ?>
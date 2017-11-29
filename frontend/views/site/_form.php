<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<p>Пожалуйста, заполните следующие поля:</p>
<div class="row">
	<div class="col-lg-5">
		<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
		<?= $form->field($model, 'username', ['template' => '{label}{error}{input}']) ?>
		<?= $form->field($model, 'name1', ['template' => '{label}{error}{input}']) ?>
		<?= $form->field($model, 'name2', ['template' => '{label}{error}{input}']) ?>
		<?= $form->field($model, 'name3', ['template' => '{label}{error}{input}']) ?>
		<?= $form->field($model, 'email', ['template' => '{label}{error}{input}']) ?>
		<?= ($this->context->action->id != 'update')?$form->field($model, 'password', ['template' => '{label}{error}{input}'])->passwordInput():''?>
		<div style="padding:10px 0px;">
			<?= Html::submitInput('Сохранить', ['class' => 'btn btn-primary']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
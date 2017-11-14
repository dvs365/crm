<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<p>Пожалуйста, заполните следующие поля, чтобы зарегистрироваться:</p>
<div class="row">
	<div class="col-lg-5">
		<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
		<?= $form->field($model, 'username') ?>
		<?= $form->field($model, 'name1') ?>
		<?= $form->field($model, 'name2') ?>
		<?= $form->field($model, 'name3') ?>
		<?= $form->field($model, 'email') ?>
		<?= ($this->context->action->id != 'update')?$form->field($model, 'password')->passwordInput():''?>
		<div class="form-group">
			<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Todo */
/* @var $form yii\widgets\ActiveForm */
?>

<div cust-content edit-card>

	<?php $form = ActiveForm::begin(); ?>

	<div cust-inf-block com-inf add-doing>
		<?= $form->field($model, 'name', ['options' => ['class' => 'client_field'], 'template' => "{error}{input}"])->textInput(['maxlength' => true, 'title' => 'Название дела', 'placeholder' => 'Название дела (обязательное поле)']) ?>
		<p quick-name><?= Html::a('Звонок', false, ['not-link' => '', 'id' => 'tell'])?><?= Html::a('Письмо', false, ['not-link' => '', 'id' => 'mail'])?><?= Html::a('Счет', false, ['not-link' => '', 'id' => 'bill'])?><?= Html::a('Контроль оплаты', false, ['not-link' => '', 'id' => 'check'])?></p>
			<div class="marginup20">Завершить:
				<?= $form->field($model, 'date', ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'id' => 'date']) ?>
				в<?= $form->field($model, 'time', ['options' => ['class' => 'client_field'], 'template' => "{input}"])->input('time') ?>
				ИЛИ с <?= $form->field($model, 'date1', ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'id' => 'datestart']) ?>
				по<?= $form->field($model, 'date2', ['options' => ['class' => 'client_field'], 'template' => "{input}"])->textInput(['maxlength' => true, 'id' => 'dateend']) ?>
				<?= $form->field($model, 'repeat', ['options' => ['class' => 'client_field'], 'template' => "{input}"])->dropDownList([$model::REPEAT_NO => 'не повторять', $model::REPEAT_DAY => 'каждый день', $model::REPEAT_WEEK => 'каждую неделю', $model::REPEAT_MONTH => 'каждый месяц', $model::REPEAT_YEAR => 'каждый год', ]) ?>
			</div>
		<p>
			<?= $form->field($model, 'desc', ['options' => ['class' => 'client_field'], 'template' => "{error}{input}"])->textarea(['maxlength' => true, 'title' => 'Описание дела', 'placeholder' => 'Описание']) ?>
		</p>
	</div>
	<div bot-fixed clearfix><div><?= Html::submitInput('Сохранить')?><?= Html::buttonInput('Отменить', ['onclick' => "javascript:location.href='".Yii::$app->request->referrer."'",'fl-right' => ''])?></div>
	<?php ActiveForm::end(); ?>

</div>
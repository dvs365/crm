<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */


?>
<div cust-content edit-card>

	<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

	<div cust-inf-block com-inf>
		<div tit>Информация об организации</div>
		<?= $form->field($model, 'name', ['options' => ['class' => 'client_field'], 'template' => "{error}{input}"])->textInput(['class' => '', 'title' => 'Условное название', 'placeholder' => 'Условное название']) ?>
		<?= $this->render('_form_clientjur', [
			'form'	=> $form,
			'modelsClientJur' => $modelsClientJur,
			'model' => $model
		]);
		?>

		<div bot-fixed clearfix><div><?= Html::submitInput('Сохранить')?><?= Html::buttonInput('Отменить', ['onclick' => "javascript:location.href='".Yii::$app->request->referrer."'",'fl-right' => ''])?></div></div>
	<?php ActiveForm::end(); ?>

</div>

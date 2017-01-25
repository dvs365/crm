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
			<?= Html::a('<span>&#9875</span><span bird>&#10004</span>','#', ['title' => 'Якорный клиент', 'class' => 'add-main']).'<-checkbox может?'?>
			<?= $this->render('_form_clientjur', [
				'form'	=> $form,
				'modelsClientJur' => $modelsClientJur,
				'model' => $model
			]).
			$this->render('_form_client_phone', [
				'form'	=> $form,
				'modelsClientPhone' => $modelsClientPhone,
				'model' => $model
			]).
			$this->render('_form_client_mail', [
				'form'	=> $form,
				'modelsClientMail' => $modelsClientMail,
				'model' => $model
			]);
			?>
		</div>
		<div cust-inf-block cont-inf>
		<?= $this->render('_form_client_contact', [
			'form'	=> $form,
			'modelsClientContact' => $modelsClientContact,
			'modelsClientContactPhone' => $modelsClientContactPhone,
			'modelsClientContactMail' => $modelsClientContactMail,
			'model' => $model
			]);
		?>
		</div>
		<div cust-inf-block adress-inf>
			<div tit>Адреса:</div>
			<?= $this->render('_form_client_address', [
				'form'	=> $form,
				'modelsClientAddress' => $modelsClientAddress,
				'model' => $model
			]);
			?>
		</div>
		<div cust-inf-block dop-inf>

		</div>
		<div bot-fixed clearfix><div><?= Html::submitInput('Сохранить')?><?= Html::buttonInput('Отменить', ['onclick' => "javascript:location.href='".Yii::$app->request->referrer."'",'fl-right' => ''])?></div>
	<?php ActiveForm::end(); ?>

</div>

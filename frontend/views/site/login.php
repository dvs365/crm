<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div allwr>
    <div login centering>
		<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($model, 'username', ['options' => ['class' => '', 'row' => ''], 'template' => '{input}'])->textInput(['class' => '', 'placeholder' => 'Пользователь', 'set' => 'focus']) ?>

			<?= $form->field($model, 'password', ['options' => ['class' => '', 'row' => ''], 'template' => '{input}'])->passwordInput(['class' => '', 'placeholder' => 'Пароль']) ?>

			<?= '<div row>'.Html::submitInput('Войти').'</div>'?>

			<?= ($model->errors)?'<div message="error" end-life="input-type">Ошибка входа</div>':''?>

		<?php ActiveForm::end(); ?>
    </div>
</div>

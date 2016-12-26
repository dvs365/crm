<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Client */
/* @var $form yii\widgets\ActiveForm */
?>

<div cust-content edit-card>

	<?php $form = ActiveForm::begin(); ?>

	<div cust-inf-block com-inf>
		<div tit>Информация об организации</div>
		<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Условное название', 'placeholder' => 'Условное название']) ?><a href="javascript:void(0);" class="add-main" title="Якорный клиент"><span>&#9875 </span><span bird>&#10004 </span></a>
		<?= $form->field($model, 'namelaw', ['options' => ['class' => ''], 'template' => "{input}"])->textInput(['class' => '', 'title' => 'Юр. лицо', 'placeholder' => 'Полное название юр. лица']) ?><a add-jur href="javascript:void(0);" title="Добавить"><span add>&#10011 </span></a>
		<p>Телефон:</p>
		<u>
			<?= $form->field($model, 'user', ['options' => ['class' => ''], 'template' => '{input}{error}'])->textInput(['class' => '', 'title' => 'Код страны', 'placeholder' => '+7', 'country'=>'']) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Код города/оператора', 'placeholder' => '919', 'city'=>'']) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Номер', 'placeholder' => '456-45-45', 'number'=>'']) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий', 'phone-comment'=>'']) ?>
		</u><a add-phone href="javascript:void(0);" title="Добавить"><span add>&#10011 </span></a>
		<p>E-mail:</p>
		<u>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'E-mail', 'placeholder' => 'E-mail', 'e-mail' => '']) ?>
			<?= $form->field($model, 'name', ['template' => '{input}'])->textInput(['class' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий', 'mail-comment' => '', 'mail-comment' => '']) ?>
		</u><a add-mail href="javascript:void(0);" title="Добавить"><span add>&#10011 </span></a>
	</div>
	<div cust-inf-block cont-inf>
		<div tit>Контактные лица:</div>
		<div num>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'ФИО', 'placeholder' => 'ФИО']) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->checkbox(['title' => 'Основное контактное лицо'], false) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Должность', 'placeholder' => 'Должность']) ?>
			<p>Телефон:</p>
			<u phoneremove>
				<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Код страны', 'placeholder' => '+7', 'country'=>'']) ?>
				<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Код города/оператора', 'placeholder' => '919', 'city'=>'']) ?>
				<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Номер', 'placeholder' => '456-45-45', 'number'=>'']) ?>
				<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий', 'phone-comment'=>'']) ?>
			</u><a add-phone1 href="javascript:void(0);" title="Добавить"><span add>&#10011 </span></a>
			<p>E-mail:</p>
			<u mailremove>
				<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'E-mail', 'placeholder' => 'E-mail']) ?>
				<?= $form->field($model, 'name', ['template' => '{input}'])->textInput(['class' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий', 'mail-comment' => '']) ?>
			</u><a add-mail1 href="javascript:void(0);" title="Добавить"><span add>&#10011 </span></a>
		</div>
		<p add-contact><a href="javascript:void(0);" cust-add>Добавить контактное лицо</a></p>
	</div>
	<div cust-inf-block adress-inf>
		<div tit>Адреса:</div>
		<div num>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Страна', 'placeholder' => 'Страна']) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Регион', 'placeholder' => 'Регион']) ?>
			<br />
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Город', 'placeholder' => 'Город']) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Улица', 'placeholder' => 'Улица']) ?>
			<br />
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Дом/корпус/офис', 'placeholder' => 'Дом/корпус/офис']) ?>
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Комментарий', 'placeholder' => 'Комментарий']) ?>
			<br />
			<!-- не у всех пользователей -->
			<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->textInput(['class' => '', 'title' => 'Заметка суперпользователя', 'placeholder' => 'Заметка суперпользователя']) ?>
			<p class="expand-link"><a href="javascript:void(0);" cust-add>Отобразить на карте</a></p>
			<div class="expand-block">ЯНДЕКС-КАРТА!!! УРА!!!!!</div>
		</div>
		<p add-adress><a href="javascript:void(0);" cust-add>Добавить адрес</a></p>
	</div>
	<div cust-inf-block dop-inf><!-- не у всех пользователей -->
		<p>Назначить менеджера</p>
		<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->dropDownList(['0' => '', '2' => '_система_ автодобавления', '44' => 'Козырев Дмитрий Николаевич'], ['class' => '']) ?>
		<p>Дополнительный просмотр</p>
		<?= $form->field($model, 'name', ['options' => ['class' => ''], 'template' => '{input}'])->dropDownList(['0' => '', '2' => '_система_ автодобавления', '44' => 'Козырев Дмитрий Николаевич'], ['class' => '']) ?>
	</div>


	<div bot-fixed clearfix><div>
		<?= Html::submitInput($model->isNewRecord ? 'Создать' : 'Сохранить') ?>
		<?= Html::submitInput('Отменить', ['fl-right' => '']) ?>
	</div></div>

	<?php ActiveForm::end(); ?>

</div>

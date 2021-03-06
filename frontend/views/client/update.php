<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Client */

$this->title = 'Редактировать карточку';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div workarea>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsClientJur' => $modelsClientJur,
		'modelsClientPhone' => $modelsClientPhone,
		'modelsClientMail' => $modelsClientMail,
		'modelsClientContact' => $modelsClientContact,
		'modelsClientContactPhone' => $modelsClientContactPhone,
		'modelsClientContactMail' => $modelsClientContactMail,
		'modelsClientAddress' => $modelsClientAddress,
		'modelsUser' => $modelsUser,
    ]) ?>

</div>

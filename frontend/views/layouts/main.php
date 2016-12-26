<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= Yii::$app->language ?>">
<head>
    <meta content="text/html";  charset="<?= Yii::$app->charset ?>" http-equiv="Content-Type">
    <meta name="viewport" content="width=980">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div wrapper>
    <?php
	if (!Yii::$app->user->isGuest) {
		NavBar::begin([
			'brandLabel' => 'ООО СФЕРАОПТ',
			'brandUrl' => Yii::$app->homeUrl,
			'options' => [
				'class' => 'navbar-inverse navbar-fixed-top',
			],
		]);
		$menuItems = [
			['label' => 'Сводка', 'url' => ['/site/press']],
			['label' => 'Продажи', 'url' => ['/site/sale']],
			['label' => 'Дела', 'url' => ['/site/business']],
			['label' => 'Почта', 'url' => ['/site/mail']],
			['label' => 'Клиенты', 'url' => ['/client/index']],
			['label' => 'Функции', 'url' => ['/site/function']],
		];
		if (Yii::$app->user->can('moder')) {
			$menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
		}
		$menuItems[] = [
			'label' => 'Выйти (' . Yii::$app->user->identity->username . ')',
			'url' => ['/site/logout'],
			'linkOptions' => ['data-method' => 'post']
		];
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => $menuItems,
		]);
		NavBar::end();
	}
    ?>

        <?/*= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])*/ ?>
        <?= Alert::widget() ?>
        <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

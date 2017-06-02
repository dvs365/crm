<?

use yii\helpers\Html;
use yii\widgets\Menu;

?>
<? if (!Yii::$app->user->isGuest) {?>
<div allwr>
	<div headerwr clearfix>
		<div user>
			<div username><?= Yii::$app->user->identity->name1.' '.Yii::$app->user->identity->name2.' '.Yii::$app->user->identity->name3?><div long-text-hide></div></div>
			<?= Html::a('Настройки', '#')?>
			<?= Html::a('Справка', '#')?>
			<?= Html::a('Выход', ['site/logout'])?>
		</div>
		<? $checkController = function ($route) {
			return $route === $this->context->getUniqueId();
		}?>
		<?= Menu::widget([
			'items' => [
				['label' => 'Сводка', 'url' => ['site/press']],
				['label' => 'Продажи', 'url' => ['site/sale']],
				['label' => 'Дела', 'url' => ['todo/day'], 'active' => $checkController('todo')],
				['label' => 'Почта', 'url' => ['site/mail']],
				['label' => 'Клиенты', 'url' => ['client/index'], 'active' => $checkController('client')],
				['label' => 'Функции', 'url' => ['site/function'], 'visible' => Yii::$app->user->can('moder')],
				['label' => 'Регистрация', 'url' => ['site/signup'], 'visible' => Yii::$app->user->can('moder')],
			],
			'activeCssClass' => 'cur',
			'options' => [
				'navig' => 'main',
			]
		])?>
	</div>
<?= $content?>
</div>
<?}
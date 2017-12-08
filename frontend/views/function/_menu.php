<?php

use yii\widgets\Menu;

?>

<?= Menu::widget([
    'items' => [
        ['label' => 'Проверка изменений', 'url' => ['function/index']],
        ['label' => 'Проверка отказов', 'url' => ['function/check_reject']],
        ['label' => 'Передача клиентов', 'url' => ['function/transfer']],
        ['label' => 'Дополнительный доступ', 'url' => ['function/addaccess']],
    ],
    'activeCssClass' => 'cur',
    'options' => [
        'cust-dop-menu' => '',
    ]
])?>
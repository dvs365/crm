<?php
date_default_timezone_set('Europe/Samara');
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
	'language'=>'ru-RU',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'common\bootstrap\SetUp',
    ],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'assetManager' => [
			'bundles' => [
				'yii\web\JqueryAsset' => [
					'sourcePath' => null,
					'js' => ['frontend/web/js/jquery-1.11.1.min.js'],
				]
			]
		],
		'formatter' => [
			'dateFormat' => 'dd.MM.yyyy',
			'timeFormat' => 'HH:mm',
			'timeZone' => 'UTC',
			'decimalSeparator' => ',',
			'thousandSeparator' => ' ',
			'currencyCode' => 'EUR',
		],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        'cache' => [
            'class' => 'yii\caching\FileCache',
            
        ],
    ],
	'modules' => [
		'debug' =>[
			'class' => 'yii\debug\Module',
			'allowedIPs' => ['*'],
		]
	],
    'as access' => [
        'class' => 'yii\filters\AccessControl',
        'except' => ['site/login', 'site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
            [
                'actions' => ['client/create'],
                'allow' => true,
                'roles' => ['createClient'],
            ],
        ],
    ],
    'params' => $params,
];

<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/design.css',
		'css/base.css',
		//'css/jquery-ui.min.css',
    ];
    public $js = [
    	'js/jquery-1.11.1.min.js',
		'js/base.js',
		'js/jquery-ui.min.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
       // 'yii\bootstrap\BootstrapAsset',
    ];
}

<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class TodoAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/jquery-ui-1.8.21.custom.css',
	];
	public $js = [
		'js/jquery.ui.datepicker-ru.js',
		'js/todo.name.insert.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];

}

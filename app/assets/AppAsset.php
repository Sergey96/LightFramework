<?php

namespace app\assets;

/**
 * Main frontend application asset bundle.
 */
/// Подключение css, js к сайту
class AppAsset 
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
	/// Массив css-стилей
    public $css = [
        'css/site.css',
        'css/highlight/default.css',
        'css/main.css',
    ];
	/// Массив js-скриптов
    public $js = [
		'js/highlight/highlight.pack.js',
		'js/highlight/init.js'
    ];
	/// Массив зависимостей
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

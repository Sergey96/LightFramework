<?php

namespace frontend\assets;

use engine\core\asset\Asset;

/**
 * Main frontend application asset bundle.
 */
/// Подключение css, js к сайту
class AppAsset extends Asset
{
    public static $basePath = '@webroot';
    public static $baseUrl = '@web';
	/// Массив css-стилей
    public static $css = [
        '/css/bootstrap.min.css',
        //'/css/font-awesome.min.css',
        '/dist/sidebar-menu.css',
        '/css/maket.css',
        '/css/site.css',
        //'/css/highlight/default.css',
        '/css/main.css'
    ];
	/// Массив js-скриптов
    public static $js = [
		'/js/jquery-3.0.0.min.js',
		'/js/bootstrap.min.js',
		'/dist/sidebar-menu.js'
    ];
}

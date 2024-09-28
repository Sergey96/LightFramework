<?php
/**
 * Главный файл конфигурации
 */
return [
	'db'=>[
		'host'=>'localhost',
		'login'=>'root',
		'password'=>'',
		'dbname'=>'light',
        'charset' => 'utf8',
	],
	'controller'=>[
		'default'=>'Users'
	],
	'mode' => \engine\App::DEBUG_MODE,
	'home'=>str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']),
	'namespace'=>'admin',
];

?>



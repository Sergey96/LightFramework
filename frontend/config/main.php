<?php
/**
 * Главный файл конфигурации
 */
return [
	'db'=>[
		'host'=>'localhost',
		'login'=>'root',
		'password'=>'123456',
		'dbname'=>'light',
	],
	'controller'=>[
		'default'=>'Home'
	],
	'home'=>str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']),
	'namespace'=>'frontend',
];

?>
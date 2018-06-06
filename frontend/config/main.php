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
	],
	'controller'=>[
		'default'=>'Home'
	],
	'home'=>str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']),
	'namespace'=>'frontend',
];

?>
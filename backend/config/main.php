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
		'default'=>'Users'
	],
	'home'=>str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']),
	'namespace'=>'backend',
];

?>
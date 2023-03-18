<?php
/**
 * Главный файл конфигурации
 */
return [
	'db'=>[
		'host'=>'localhost',
		'login'=>'root',
		'password'=>'',
		'dbname'=>'vk_parser',
        'charset' => 'utf8',
	],
	'controller'=>[
		'default'=>'Users'
	],
	'home'=>str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']),
	'namespace'=>'admin',
];

?>



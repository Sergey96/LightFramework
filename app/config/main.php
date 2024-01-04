<?php
/**
 * Главный файл конфигурации
 */
return [
    'db' => [
        'host' => 'localhost',
        'login' => 'admin',
        'password' => '123456',
        'dbname' => 'vk',
    ],
    'controller' => [
        'default' => 'Home'
    ],
    'home' => str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']),
    'namespace' => 'app',
    'mode' => 'DEBUG_MODE'
];

?>
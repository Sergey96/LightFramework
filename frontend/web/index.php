<?php
	// Подключение автозагрузчика классов
	require_once '../../Autoloader.php';
	// Получение конфигурации приложения
	$config = require '../config/main.php';
	// Создание экземпляра приложения
	$app = new engine\WebApp($config);


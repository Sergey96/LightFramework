<?php

namespace engine;

use engine\Components\URLManager;
use engine\base\Exceptions as Exceptions;
use app\controllers;
use app\models;
use engine\Request\Request;
use engine\DB\DataBase;
use engine\base\Log\Logger;
use engine\base\User\User;

/**
 * WebApp - основной класс приложения
 */
/// WebApp - основной класс приложения
class WebApp 
{

	/// Массив конфигурации app/config/main.php
	public static $config;
	/// Объект request - содержит данные get и post запросов
	public static $request;
	/// Объект connection - соединение с БД
	public static $connection;
	/// Объект Error - ошибки приложения
	public static $error;
	/// Объект logger - система логирования
	public static $logger;
	/// Объект текущего контроллера приложения (default из main.php)
	public static $controller;
	/// Базовый каталог приложения
	public static $home;
	/// Объект user - текущий пользователь
	public static $user;
	/// Строка time - Время для замера производительности
	public static $time;
	/// Объект URL - компонент URLManager
	public $URL;
	
	/**
	 * инициализация приложения
	 * - установка собственного обработчика ошибок
	 * - запуск системы логирования
	 * - получение конфигурации приложения из файлов папки app/config
	 * - получение данных get и post запросов
	 * TODO
	 * - установка соединения с БД 
	 * - получение корневой директории проекта
	 * - получение информации о текущем пользователе
	 * - запуск приложения
	 */
	public function __construct($config){
		session_start();
		if(!isset($_SESSION['start_time']))
			$_SESSION['start_time'] = microtime();
		set_error_handler("\\engine\\WebApp::myErrorHandler");
		WebApp::$config = $config;
		WebApp::$request = new Request($_GET, $_POST);
		WebApp::$logger = new Logger();
		WebApp::$connection = new DataBase($config['db']);
		WebApp::$home = $this->levelUpDir($this->levelUpDir($config['home']));
		WebApp::$user = new User();		//exit();
		$this->run();
		$_SESSION['end_time'] = microtime();
		print_r($_SESSION['end_time'] - $_SESSION['start_time']);
	}
	
	/**
	 * Запуск приложения
	 * Ищем необходимый контроллер
	 * Ищем требуемый action в контроллере и выполняем его
	 * В случае неудачи выводим красивую страницу ошибки
	 */
	private function run(){
		try {
			$this->URL = new URLManager(WebApp::$config);
			switch($this->URL->Controller){
				case "Gii": $control = "engine\\components\\Gii\\Gii"; break;
				default : $control = self::$config['namespace']."\\controllers\\".$this->URL->Controller; break;
			}
		
			if (!class_exists($control)){
				$control = "engine\\controller\\Controller";
				WebApp::$controller = new $control($this->URL);
				throw new Exceptions\URLNotFoundException($this->URL->Controller);
			}
			WebApp::$controller = new $control($this->URL);
			WebApp::$controller->selectAction();
		}
		catch(\Exception $e){
			$control = "engine\\controller\\Controller";
			WebApp::$controller = new $control($this->URL);
			WebApp::$controller->ViewPath = '../../'.WebApp::$config['namespace'].'/views/';
			WebApp::$controller->Name = 'home';
			WebApp::$controller->error($e);
		}
	}
	
	/**
	 * Собственный обработчик ошибок и исключений
	 * - Ловим все исключения которые можем и отправляем на свою страницу ошибки
	 * - FATAL_ERROR Ловить не получается
	 */
	public static function myErrorHandler($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno)) {
			
			// Этот код ошибки не включен в error_reporting
			return;
		}

		switch ($errno) {
		case E_USER_ERROR:
			echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
			echo "  Фатальная ошибка в строке $errline файла $errfile";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "Завершение работы...<br />\n";
			exit(1);
			break;

		case E_USER_WARNING:
			echo "<b>My WARNING </b> [$errno] $errstr<br />\n";
			die();
			break;

		case E_USER_NOTICE:
			echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
			die();
			break;

		default:
			throw new Exceptions\Exception($errno, $errstr, $errfile, $errline);
			break;
		}

		/* Не запускаем внутренний обработчик ошибок PHP */
		return true;
	}

	/**
	 * Подняться на уровень вверх
	 * - нужно когда пусть приходит в виде строки
	 */
	private function levelUpDir($path){
		$pos = strrpos($path, '/', -0);
		return substr($path, 0, $pos);
	}
	
}

?>
<?php

namespace engine;

use engine\core\components\URLManager;
use engine\core\exceptions as Exceptions;
use engine\core\request\Request;
use engine\core\DB\DataBase;
use engine\core\log\Logger;
use engine\core\user\User;
use engine\controller\Error as ErrorController;
use engine\base\controllers\Controller;

/**
 * WebApp - основной класс приложения
 */
/// WebApp - основной класс приложения
class WebApp 
{

	/// Массив конфигурации app/config/main.php
	public static array $config;
	/// Объект request - содержит данные get и post запросов
	public static Request $request;
	/// Объект connection - соединение с БД
	public static DataBase $connection;
	/// Объект Error - ошибки приложения
	public static ErrorController $error;
	/// Объект logger - система логирования
	public static Logger $logger;
	/// Объект текущего контроллера приложения (default из main.php)
	public static Controller $controller;
	/// Основной каталог приложения
	public static string $home;
    /// Базовый каталог фреймворка
	public static string $basePath;
	/// Объект user - текущий пользователь
	public static User $user;
	/// Строка time - Время для замера производительности
	public static $time;
	/// Объект URL - компонент URLManager
    /**
     * @var URLManager
     */
    public static URLManager $URL;

    public const DEBUG_MODE = 'DEBUG_MODE';
    public const PROD_MODE = 'PROD_MODE';

    public static $MODE;
	
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
		set_error_handler("\\engine\\WebApp::LightErrorHandler");
		error_reporting(0);

        WebApp::$config = $config;
        self::$MODE = $config['mode'] ?? self::PROD_MODE;
		$this->run();
	}

	public function isAjaxMode()
    {
        return strpos($_SERVER['HTTP_ACCEPT'], "json") !== false;
    }

    public function isDebug()
    {
        return self::$MODE === self::DEBUG_MODE;
    }
	
	/**
	 * Запуск приложения
	 * Ищем необходимый контроллер
	 * Ищем требуемый action в контроллере и выполняем его
	 * В случае неудачи выводим красивую страницу ошибки
	 */
	private function run(){
        $isAjax = self::isAjaxMode();

		try {
            self::$request = new Request($_GET, $_POST);

            self::$logger = new Logger();

            self::$home = $this->levelUpDir($this->levelUpDir(self::$config['home']));
            self::$home = $this->levelUpDir($this->levelUpDir($this->levelUpDir(self::$config['home'])));
            self::$basePath = $this->levelUpDir($this->levelUpDir($this->levelUpDir(self::$config['home'])));

//            print_r(self::$home);
			self::$URL = new URLManager(self::$config);
            self::$connection = new DataBase(self::$config['db']);
            self::$user = new User();
            $control = $this->getController();

            self::$controller = new $control(self::$URL, $isAjax);
            echo self::$controller->execAction();
		}
		catch(\Exception $e){
			$this->responseError($e, $isAjax);
		}
		catch(\Error $e){
            $this->responseError($e, $isAjax);
		}
	}

	private function responseError($e, $isAjax)
    {
        self::$controller = new ErrorController(self::$URL, $isAjax);

        echo self::$controller->actionError($e);
    }

	private function getController()
    {
        switch(self::$URL->Controller){
            case "Gii": $control = "engine\\components\\Gii\\Gii"; break;
            default : $control = self::$config['namespace']."\\controllers\\".self::$URL->Controller; break;
        }

        if (!class_exists($control)){
            throw new Exceptions\URLNotFoundException(self::$URL->Controller);
        }

        return $control;
    }
	
	/**
	 * Собственный обработчик ошибок и исключений
	 * - Ловим все исключения которые можем и отправляем на свою страницу ошибки
	 * - FATAL_ERROR Ловить не получается
	 */
	public static function LightErrorHandler($errno, $errstr, $errfile, $errline)
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

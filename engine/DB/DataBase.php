<?php

namespace engine\DB;

use engine\Models\Model;
use engine\DB\DBManager;

/**
 * DataBase - Класс для работы с БД
 */
class DataBase extends Model
{
	private $Connection;
	private $Host;
	private $Login;
	private $Password;
	private $DBName;
	private $Status;
	private $Config;
	
    /**
     * Конструктор класса, создает соединение с БД
     */
	public function __construct($config){
		$this->Config = $config;
		$this->Status = false;
	}
	
	/**
	* Инициализация
	*/
	
	private function Init(){
		if($this->Status==false){
			$this->Connection = new \PDO
			(
				"mysql:host=".$this->Config['host'].";dbname=".$this->Config['dbname'], 
				$this->Config['login'], $this->Config['password'], 
				array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
			);
			$this->Status = true;
		}
	}
	
    /**
     * Выполнение произвольного SQL-запроса
     */
	public function executeQuery($query){
		$this->Init();
		return $this->Connection->query($query);
	}
	
	/**
     * Подготовка \PDO->SQL - запроса
     */
	public function prepare($query){
		$this->Init();
		return $this->Connection->prepare($query);
	}
	
    /**
     * Просмотр ошибок при выполнении запросов к БД
     */
	public function getErrors(){
		$this->Init();
		return $this->Connection->errorInfo();
	}

}

?>
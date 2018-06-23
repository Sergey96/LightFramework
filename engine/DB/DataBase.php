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
		$this->Init();
	}
	
	/**
	* Инициализация
	*/
	
	private function Init(){
		if($this->Status==false){
			try{
				$opt = [
					\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
					\PDO::ATTR_EMULATE_PREPARES   => false,
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
				];
				$this->Connection = new \PDO
				(
					"mysql:host=".$this->Config['host'].";dbname=".$this->Config['dbname'],//.";'collation' => 'utf8'", 
					$this->Config['login'], $this->Config['password'], $opt
				);
				$this->Status = true;
			}
			catch(\PDOException $e){
				throw $e;
			}
		}
	}
	
    /**
     * Выполнение произвольного SQL-запроса
     */
	public function executeQuery($query){
		return $this->Connection->query($query);
	}
	
	/**
     * Подготовка \PDO->SQL - запроса
     */
	public function prepare($query){
		return $this->Connection->prepare($query);
	}
	
    /**
     * Просмотр ошибок при выполнении запросов к БД
     */
	public function getErrors(){
		return $this->Connection->errorInfo();
	}

}

?>
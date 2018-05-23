<?php

namespace engine\DB;
use engine\Models\Model;

class DataBase extends Model
{
	private $Connection;
	private $Host;
	private $Login;
	private $Password;
	private $DBName;
    /**
     * Login action.
     *
     * @return string
     */
	public function __construct($config){
		$this->Connection = new \PDO("mysql:host=".$config['host'].";dbname=".$config['dbname'], $config['login'], $config['password']);
	}
	
	public function executeQuery($query){
		return $this->Connection->query($query);
	}
	
	public function getErrors(){
		return $this->Connection->errorInfo();
	}
}

?>
<?php

namespace engine\db\DataProvider;

use engine\WebApp;
use engine\db\DataProvider\DataProviderFrom;

class DataProvider
{
	private $query;
	private $all;
	private $asArray;
	
	public function __construct($query = ''){
		$this->query = $query;
	}
	
	public function select($FieldList){
		$fields = $this->getStringFromArray($FieldList);
		$this->query = "SELECT $fields ";
		return new DataProviderFrom($this->query);
	}
	
	private function getStringFromArray($array){
		$str ='';
		foreach($array as $k =>$v)
		{
			if($k==0)
				$str .= "`".$v."`";
			else
				$str .= ", `".$v."`";
		}
		return $str;
	}

	public function all(){
		$this->all = 1;
		return $this;
	}
	
	public function asArray(){
		$this->asArray = 1;
		return $this;
	}
	
	public function One(){
		$this->query .= ' LIMIT 1';
		return $this;
	}

	public function exe($class = null){
		$result = WebApp::$connection->executeQuery($this->query);
		if (!$result) {
			throw new Exceptions\DataBaseException(WebApp::$connection->getErrors()[2].' '.$this->query);
		}
		if($this->asArray)
			return $result->fetchAll(\PDO::FETCH_ASSOC);
		if($this->all){
			return $result->fetchAll(\PDO::FETCH_CLASS, $class);
		}
	}
	
}

?>
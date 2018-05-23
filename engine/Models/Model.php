<?php

namespace engine\Models;

use engine\WebApp;
use engine\base\Exceptions as Exceptions;

class Model 
{
	protected $attributes_;
	protected $tableName;
	
	public function setTableName($table){
		$this->tableName = $table;
	}

	public function loadData($array){
		if(!is_array($array))
			throw new \Exception("Не Удается загрузить данные в модель");
		$properties = $this->getProperty();
		$countLoadedElem = 0;
		
		foreach($properties as $k => $v){
			if(isset($array[$v])){
				$this->$v = $array[$v];
				$countLoadedElem++;
			}
		}
		
		if($countLoadedElem != count($array)-1){
			return false;
		}
		return true;
	}
	
	public function load($array){
		if(!is_array($array))
			throw new \Exception("Не Удается загрузить данные в модель");
		$this->getTableColumns();
		
		
		$countLoadedElem = 0;
		foreach($this->attributes_ as $k => $v){
			if(isset($array[$k])){
				$this->attributes_[$k]->Value = $array[$k];
				$countLoadedElem++;
			}
		}
		print_r($this);
		print_r($array);
		exit();
		if(count($countLoadedElem)!=count($array)){
			return false;
		}
		print_r($this);
		exit();
		return true;
	}
	
	public function getData($fieldList){
		return $this->getDataFromDB($fieldList);
	}
	
	
	/**
     * Получение списка полей класса
     *
     * @return array
     * @throws \ReflectionException
     */
	public function getProperty(){
		$an_array = array();
		$reflection = new \ReflectionClass($this);
		$properties = $reflection->getProperties();
		foreach ($properties as $k => $property)
			{
			$property->setAccessible(true);
			$an_array[$property->getName()] = $property->getValue($this);
			if (!$property->isPublic())
				$property->setAccessible(false);
			}
			
		$ClassName = $this->getClassName();
		$pr = array();
		foreach($properties as $key => $value){
			if(isset($value->class)){
				if($value->class == $ClassName && $value->isPublic()){
					$pr[] = $value->getName();
				}
			}
		}
		return $pr;
	}
	
	/**
     * Возвращает имя текущего класса
     *
     * @return string
     */
	public function getClassName(){
		return get_class($this);
	}
	
	public function getTableColumns()
	{
		try 
		{
			$query = WebApp::$connection->executeQuery("SHOW COLUMNS FROM `".$this->tableName."`");
			if (!$query) {
				print_r(WebApp::$connection->getErrors());
				throw new Exceptions\DataBaseException(WebApp::$connection->getErrors()[2].' '.$this->tableName);
			}
			$columns = $query->fetchAll(\PDO::FETCH_CLASS, "engine\Components\Gii\models\Column");
			foreach($columns as $column){
				$this->attributes_[$column->Field] = $column;
				$this->attributes_[$column->Field]->Value = 0;
			}
		}
		catch (\Exception $e){
			print_r($e);
			throw $e;
		}
	}
}

?>
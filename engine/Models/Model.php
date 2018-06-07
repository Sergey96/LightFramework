<?php

namespace engine\Models;

use engine\WebApp;
use engine\base\Exceptions as Exceptions;
/**
 *  Базовый Класс Модели
*/
/// Базовый Класс Модели
class Model 
{
	/// Список полей модели
	protected $attributes_;
	/// Имя таблицы модели
	protected $tableName;
	private $ErrorLoad = false;
	
	/**
	 * Установить имя таблицы
	*/
	public function setTableName($table){
		$this->tableName = $table;
	}
	
	public function getErrorsLoad(){
		return $this->ErrorLoad;
	}
	
	/**
	 * Загрузить данные в модель из массива
	*/
	public function load($array){
		if(!is_array($array))
			throw new \Exception("Не Удается загрузить данные в модель");
		$class = get_called_class();
		$rules = $class::$attributeLabels;
		foreach($rules as $k => $v){
			if($rules[$k][2] == 'required' && !isset($array[$k])){
				$this->ErrorLoad = 'Отсутствует обязательное поле: '.$k;
				return false;
			}
			if(isset($array[$k]) && strlen($array[$k])!=0){
				if(($rules[$k][1] == 'text' || $rules[$k][1] == 'datetime') && !is_string($array[$k])){
					$this->ErrorLoad = 'Поле не соответствует формату: '.$k.' => '.$rules[$k][1];
					return false;
				}
				if($rules[$k][1] == 'int' && !is_numeric($array[$k])){
					$this->ErrorLoad = 'Поле не соответствует формату: '.$k.' => '.$rules[$k][1];
					return false;
				}
				$this->$k = $array[$k];
			}
		}
		if(isset($this->id))
			$this->setNotNew();
		return true;
	}
	
	public function getFieldList($rules){
		$fields = array();
		foreach($rules as $k => $v)
			$fields[] = $k;
		return $fields;
	}
	
	/**
	 * Загрузить данные в модель используя список полей из БД
	*/
	public function loadData($array){
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
	
	/**
	 * Получить список полей в связанной таблице
	 */
	public function getTableColumns()
	{
		try 
		{
			$query = WebApp::$connection->executeQuery("SHOW COLUMNS FROM `".$this->tableName."`");
			if (!$query) {
				print_r(WebApp::$connection->getErrors());
				throw new Exceptions\DataBaseException(WebApp::$connection->getErrors()[2].' '.$this->tableName);
			}
			$columns = $query->fetchAll(\PDO::FETCH_CLASS, "engine\components\Gii\models\Column");
			foreach($columns as $column){
				$this->attributes_[$column->Field] = $column;
				$this->attributes_[$column->Field]->Value = 0;
			}
		}
		catch (\Exception $e){
			//print_r($e);
			throw $e;
		}
	}
}

?>
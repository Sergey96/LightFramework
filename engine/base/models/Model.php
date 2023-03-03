<?php

namespace engine\base\models;

use engine\WebApp;
use engine\core\Exceptions as Exceptions;
use engine\core\validator\Validator;

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
		if(count($array)==0)
			return false;
		foreach($rules as $k => $v){
			if($rules[$k][2] == 'required' && !isset($array[$k])){
				$this->ErrorLoad = 'Отсутствует обязательное поле: '.$k;
				return false;
			}
			if(isset($array[$k]) && strlen($array[$k])!=0){
				if(Validator::validate($rules[$k][1], $array[$k])){
					$this->$k = htmlspecialchars($array[$k]);
				}
				else {
					$this->ErrorLoad = 'Поле не соответствует формату "'.$rules[$k][1].'": '.$k.' => '.$rules[$k][1];
					return false;
				}
			}
		}
		if(isset($this->id))
			$this->setNotNew();
		return true;
	}
	
	public function validateDate($date, $format = 'Y-m-d H:i:s'){
		$d = date_parse_from_format($format, $date);
		return $d['warning_count'] || $d['error_count'];
	}
	
	public function getFieldList($rules){
		$fields = array();
		foreach($rules as $k => $v)
			$fields[] = $k;
		return $fields;
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
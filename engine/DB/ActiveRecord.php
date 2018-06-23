<?php

namespace engine\DB;

use engine\WebApp;
use engine\models\Model;
use engine\base\Exceptions as Exceptions;
use engine\base\Validator\Validator;

/// Класс записи в БД
class ActiveRecord extends Model
{
    /// Связанная таблица в БД
	public $Table;
	/// Существует ли запись в таблице 0 - да, 1 - нет
	protected $isNew;
	/// Объект запроса к БД
	private $queryObj;
	/// Поля с данными, не соответствующих типов
	private $fieldsErrorType;
    /**
     * Конструктор класса
     *
     * @return void
     */
	public function __construct(){
		$this->isNew = 1;
	}
	
	public function __set($name, $value) {
        $this->$name = $value;
    }
	
	public function setNotNew(){
		return $this->isNew = 0;
	}

    /**
     * Устанавливает связь с таблицей в БД
     *
     * @return void
     */
	public function setTable($table){
		$this->Table = $table;
	}
	
    /**
     * Сохраняет изменения модели в БД
     *
     * @return string
     * @throws \ReflectionException
     */
	public function save($validate = true){
		if($this->validate($validate)){
			// Создание строки запроса для сохранения
			$Query = $this->generateQuery();
			// Создание подготовленного PDO запроса
			$stmt = self::prepare($Query);
			// Выполнение подготовленного запроса
			$stmt->execute($this->getDataAsArray($this->isNew));	
			// Проверка ошибок
			
			$errors = $stmt->errorInfo();
			if($errors[1])
				throw new Exceptions\DatabaseException($errors[2]);
			else return true;
		}
		else throw new Exceptions\ErrorFieldTypeException($this->fieldsErrorType);
	}
	
	public function delete(){
		$Query = $this->deleteSQL();
		$this->exeQuery($Query);
		$errors = $this->getErrorsDB();
		if($errors[1])
			throw new Exceptions\DatabaseException($errors[2]);
	}
	
    /**
     * Генерирование INSERT - SQL запроса
     *
     * @return string
     */
    protected function insertSQL(){
        $fields = $this->getFieldsAsString();
        $data = $this->getFieldsForValueAsString();
        $query = "INSERT INTO `". $this->Table ."` ($fields) VALUES ($data)";
        return $query;
    }
	
	/**
     * Генерирование UPDATE - SQL запроса
     *
     * @todo Исправить функцию
     * @return string
     */
    protected function updateSQL(){
		$fields = $this->getFieldsForUpdateAsString();
        $query = "UPDATE `". $this->Table ."` SET  $fields WHERE id = :id";
        return $query;
    }
	
	protected function deleteSQL(){
        $query = "DELETE FROM `". $this->Table ."` WHERE id = ".$this->id;
        return $query;
    }

	    /**
     * Генерирует объект запроса к БД
     *
     * @return string
     * @throws \ReflectionException
     */
	protected function generateQuery(){
		if($this->isNew){
			return $this->insertSQL();
		}
		else {	
		    return $this->updateSQL();
		}
	}
	
	public function getFields(){
		$data = array();
		foreach($this::$attributeLabels as $k => $v)
		{
			$data[] = $k;
		}
		return $data;
	}

	protected function getFieldsAsString(){
		$string ='';
		foreach($this::$attributeLabels as $k => $v)
		{
			if($v[2]=='autoincrement')
				continue;
			if(strlen($string)==0)
				$string .= "`".$k."`";
			else
				$string .= ", `".$k."`";
		}
		return $string;
	}
		
	protected function getFieldsForValueAsString(){
		$string ='';
		foreach($this::$attributeLabels as $k => $v)
		{
			if($v[2]=='autoincrement')
				continue;
			if(strlen($string)==0)
				$string .= ":$k";
			else
				$string .= ", :$k";
		}
		return $string;
	}
	
	protected function getFieldsForUpdateAsString(){
		$string ='';
		foreach($this::$attributeLabels as $k => $v)
		{
			if($k=='id')
				continue;
			if(strlen($string)==0)
				$string .= "$k = :$k";
			else
				$string .= ", $k = :$k";
		}
		return $string;
	}

	public function getDataAsArray($isNew){
		$data = array();
		foreach($this::$attributeLabels as $k => $v)
		{
			if($v[2]=='autoincrement' && $isNew){
				continue;
			}
			$data[$k] = $this->$k;
		}
		return $data;
	}
	
	protected function validate($validate){
		if($validate){
			$issetErrors = false;
			foreach($this::$attributeLabels as $field => $properties){
				if(strlen($this->$field)==0 && $properties[2]=='required'){
					throw new Exceptions\EmptyRequiredFieldException($field);
				} 
				
				if(strlen($this->$field)!=0 && !Validator::validate($properties[1], $this->$field))
					throw new Exceptions\InvalidDataException($field);	
			}
			return true;
		}
		else return true;
	}

	/*
	['=' => ['id', '1']
	['and' => ['id', '1']]
	['or' => [
		['=' => ['id', '1']],
		['=' => ['id', '2']]
	]]
	['id', '1']]
	*/
	public function getByIDs($id){
		return $this->getByField('id', $id);
	}
	
	public function findOne($id){
		$query = "SELECT * FROM ".$this->Table." WHERE id = :id";
		$stmt = self::prepare($query);
		$result = $stmt->execute(['id'=>$id]);
		$row = $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($this));
		
		$errors = $stmt->errorInfo();
		if($errors[1])
			throw new Exceptions\DatabaseException($errors[2]);
		else {
			if(isset($row[0])){
				$row[0]->isNew = 0;
				return $row[0];
			}
			else throw new Exceptions\ModelNotFoundException($id);
		}
	}
	
	protected function exeQuery($query){
		return WebApp::$connection->executeQuery($query);
	}
	
	protected static function prepare($query){
		return WebApp::$connection->prepare($query);
	}
	
	protected function getErrorsDB(){
		return WebApp::$connection->getErrors();
	}

}

?>
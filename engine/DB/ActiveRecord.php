<?php

namespace engine\DB;

use engine\WebApp;
use engine\models\Model;
use engine\base\Exceptions as Exceptions;

/// Класс записи в БД
class ActiveRecord extends Model implements ActiveRecordInterface
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
     * Возвращает связанную таблицу
     *
     * @return string
     */
	public function getTable(){
		return $this->Table;
	}
	
    /**
     * Сохраняет изменения модели в БД
     *
     * @return string
     * @throws \ReflectionException
     */
	public function save($validate = true){
		if($this->validate($validate)){
			$Query = $this->generateQuery();
			
			$stmt = $this->prepare($Query);
			$stmt->execute($this->getDataAsArray($this->isNew));
			
			
			$errors = $stmt->errorInfo();
			if($errors[1])
				throw new Exceptions\DatabaseException($errors[2]);
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
	
	public function validate($validate){
		
		if($validate){
			$issetErrors = false;
			foreach($this::$attributeLabels as $field => $properties){
				if(strlen($this->$field)==0 && $properties[2]=='required'){
					throw new Exceptions\EmptyRequiredFieldException($field);
				} 
				else continue;
				
				if($properties[1]=='int' && is_numeric($this->$field)){
					continue;
				} 
				else throw new Exceptions\InvalidDataException($field);
				
				if($properties[1]=='text' && is_string($this->$field)){
					continue;
				} 
				else throw new Exceptions\InvalidDataException($field);
				
				if($properties[1]=='datetime' && validateDate($this->$field)){
					continue;
				} 
				else throw new Exceptions\InvalidDataException($field);
			}
			return true;
		}
		else return true;
	}
	
	public function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = date_parse_from_format($format, $date);
		return $d['warning_count'] || $d['error_count'];
	}

    /**
     * Генерирует объект запроса к БД
     *
     * @return string
     * @throws \ReflectionException
     */
	public function generateQuery(){
		if($this->isNew){
			return $this->insertSQL();
		}
		else {	
		    return $this->updateSQL();
		}
	}

    /**
     * Генерирование INSERT - SQL запроса
     *
     * @return string
     */
    public function insertSQL(){
        $fields = $this->getFieldsAsString();
        $data = $this->getFieldsForValueAsString();
        $query = "INSERT INTO `". $this->Table ."` ($fields) VALUES ($data)";
        return $query;
    }
	
	public function deleteSQL(){
        $query = "DELETE FROM `". $this->Table ."` WHERE id = ".$this->id;
        return $query;
    }
	
	public function getFieldsAsString(){
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
	
	public function getFieldsForValueAsString(){
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
	
	
	public function getFields(){
		$data = array();
		foreach($this::$attributeLabels as $k => $v)
		{
			$data[] = $k;
		}
		return $data;
	}

    /**
     * Генерирование UPDATE - SQL запроса
     *
     * @todo Исправить функцию
     * @return string
     */
    public function updateSQL(){
		$fields = $this->getFieldsForUpdateAsString();
        $query = "UPDATE `". $this->Table ."` SET  $fields WHERE id = :id";
        return $query;
    }
	
	public function getFieldsForUpdateAsString(){
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

    /**
     * Генерирование SELECT - SQL запроса
     *
     * @return string
     */
	public function select($field){
		$query = "SELECT ";
		if(is_array($field))
			$query .= $this->getStringFromArray($field);
		else
			$query .= $field;
		$query .= " FROM `".$this->Table."`";

		return $query;
	}
	
	/**
     * Получить данные в виде массива моделей
     *
     * @return string
     */
	public function getData($fieldList,  $limit){
		$query = $this->select($fieldList); 
		$query = $this->limit($query, $limit);
		print_r($query);
		//exit();
		$result = $this->exeQuery($query);
		if (!$result) {
			throw new Exceptions\DataBaseException(WebApp::$connection->getErrors()[2].' '.$this->Table);
		}
		return $result->fetchAll(\PDO::FETCH_CLASS, $this->getClassName());
	}
	
	public function limit($query, $limit){
		return $query . " LIMIT ".$limit;
	}
	
	public function where($query, $array){
		$where = ' WHERE ';
		foreach($array as $operator => $operands){
			switch($operator){
				case "=": $where .= " `".$operands[0]."` $operator '".$operands[1]."' ";
			}
		}
		return $query . $where;
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
	public function getByID($id)
	{
		return $this->getByField('id', $id);
	}
	
	public function getByField($field, $value)
	{
		$query = $this->select("*"); 
		$query = $this->where($query, ['=' => [$field, $value]]);
		
		$result = $this->exeQuery($query);
		if (!$result) {
			print_r(WebApp::$connection->getErrors());
			throw new Exceptions\DataBaseException(WebApp::$connection->getErrors()[2].' '.$this->Table);
		}
		$model = $result->fetchAll(\PDO::FETCH_CLASS, $this->getClassName());
		
		if(count($model)==0){
			$class = $this->getClassName();
			return new $class();
		}
		else {
			$model[0]->isNew = false;
			return $model[0];	
		}
	}
	
	public function getAllRecordsByField($field, $value)
	{
		$query = $this->select("*"); 
		$query = $this->where($query, ['=' => [$field, $value]]);
		
		$result = $this->exeQuery($query);
		if (!$result) {
			print_r(WebApp::$connection->getErrors());
			throw new Exceptions\DataBaseException(WebApp::$connection->getErrors()[2].' '.$this->Table);
		}
		$model = $result->fetchAll(\PDO::FETCH_CLASS, $this->getClassName());
		
		if(count($model)==0){
			$class = $this->getClassName();
			return [new $class()];
		}
		else {
			foreach($model as $v)
				$v->isNew = false;
			return $model;	
		}
	}
	
	
	public static function findByField($field, $value)
	{
		$class = get_called_class();
		$model = new $class();
		return $model->getByField($field, $value);
	}
	
	public static function findByID($id)
	{
		$class = get_called_class();
		$model = new $class();
		return $model->getByID($id);
	}

    /**
     * Преобразование имен полей и значений полей объекта в строку (через запятую)
     *
     * @return string
     */
    public function getStringFromObj($obj){
		$p = $obj->getProperty();
		$str = '';
		foreach($p as $k => $v){
			if($k==0)
				$str .= "'".$obj->$v."'";
			else 
				$str .= ", '".$obj->$v."'";
		}
		return $str;
	}

    /**
     * Преобразование массива в строку (через запятую)
     *
     * @return string
     */
	public function getStringFromArray($array){
		$str ='';
		
		foreach($array as $k =>$v)
		{
			if($k==0)
				$str .= "`".$v."`";
			else
				$str .= ", `".$v."`";
		}
		
		//print_r("FIELDLIST");
		//print_r($str);
		return $str;
	}

    /**
     * Выполняет запрос к БД и возвращает массив записей (для GridView)
     *
     * @return string
     */
	public function getDataFromDB($field){
		$fields = array();
		foreach($field as $v)
			$fields[] = $v[0];
		return $this->select($fields);
	}
	
	public function exeQuery($query){
		return WebApp::$connection->executeQuery($query);
	}
	
	public function prepare($query){
		return WebApp::$connection->prepare($query);
	}
	
	public function getErrorsDB(){
		return WebApp::$connection->getErrors();
	}

}

?>
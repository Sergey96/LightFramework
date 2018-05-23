<?php

namespace engine\DB;

use engine\DB\DataBase;

/// Класс записи в БД
class ActiveRecord extends DataBase
{
    /// Связанная таблица в БД
	public $Table;
	/// Существует ли запись в таблице 0 - да, 1 - нет
	protected $isNew;
	/// Объект запроса к БД
	private $queryObj;
    /**
     * Конструктор класса
     *
     * @return void
     */
	public function __construct(){
		$this->isNew = 1;
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
	public function save(){
		$class = $this->generateQuery();
		return $class;
	}

    /**
     * Генерирует объект запроса к БД
     *
     * @return string
     * @throws \ReflectionException
     */
	protected function generateQuery(){
		$p = $this->getProperty();
		if($this->isNew){
			return $this->insert($p);
		}
		else
		    return $this->update($p);
	}

    /**
     * Генерирование INSERT - SQL запроса
     *
     * @return string
     */
    protected function insert($property){
        $StringProperty = $this->getStringFromArray($property);
        $StringData = $this->getStringFromObj($this);
        $query = "INSERT INTO `". $this->Table ."` ($StringProperty) VALUES ($StringData)";
        return $query;
    }

    /**
     * Генерирование UPDATE - SQL запроса
     *
     * @todo Исправить функцию
     * @return string
     */
    protected function update($property){
        $StringProperty = $this->getStringFromArray($property);
        $StringData = $this->getStringFromObj($this);
        $query = "UPDATE `". $this->Table ."` SET  ($StringProperty) VALUES ($StringData)";
        return $query;
    }

    /**
     * Генерирование SELECT - SQL запроса
     *
     * @return string
     */
	public function select($field){
		$query = "SELECT ";
		$query .= $this->getStringFromArray($field);
		$query .= " FROM ".substr($this->Table, 0, -5);

		return $query;
	}

    /**
     * Преобразование имен полей и значений полей объекта в строку (через запятую)
     *
     * @return string
     */
    protected function getStringFromObj($obj){
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
	protected function getStringFromArray($array){
		$str ='';
		foreach($array as $k =>$v)
		{
			if($k==0)
				$str .= "'".$v."'";
			else
				$str .= ", '".$v."'";
		}
		return $str;
	}

    /**
     * Выполняет запрос к БД и возвращает массив записей (для GridView)
     *
     * @return string
     */
	protected function getDataFromDB($field){
		$fields = array();
		foreach($field as $v)
			$fields[] = $v[0];
		return $this->select($fields);
	}
	
	protected function exeQuery($query){
		WebApp::connection->executeQuery();
	}
}

?>
<?php

namespace engine\db\DataProvider\QueryBuilder\Mysql;

use engine\App;
use engine\core\exceptions as Exceptions;
use engine\db\DataProvider\QueryBuilder\Interface\IQueryBuilderWhere;

class MysqlQueryBuilderWhere implements IQueryBuilderWhere
{
	private $query;
	private $all;
	private $asArray;

	public function __construct($query){
		$this->query = $query;
	}

    public function where(string $where): IQueryBuilderWhere
    {
        $this->query .= " WHERE $where ";
        return $this;
    }

    public function and($and): IQueryBuilderWhere
    {
        $this->query .= " AND $and ";
        return $this;
    }

    public function or($or): IQueryBuilderWhere
    {
        $this->query .= " OR $or ";
        return $this;
    }
	
	public function all(): IQueryBuilderWhere
    {
		$this->all = 1;
		return $this;
	}
	
	public function asArray(): IQueryBuilderWhere
    {
		$this->asArray = 1;
		return $this;
	}
	
	public function One(): IQueryBuilderWhere
    {
		$this->all = 1;
		$this->query .= ' LIMIT 1';
		return $this;
	}

	public function exe($class = null): false|array|null
    {
		$result = App::$connection->executeQuery($this->query);
		if (!$result) {
			throw new Exceptions\DataBaseException(App::$connection->getErrors()[2].' '.$this->query);
		}
		if($this->asArray)
			return $result->fetchAll(\PDO::FETCH_ASSOC);
		if($this->all){
			$temp = $result->fetchAll(\PDO::FETCH_CLASS, get_class($class));
            return $temp;
		}
	}
}

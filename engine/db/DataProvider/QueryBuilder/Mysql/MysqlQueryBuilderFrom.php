<?php

namespace engine\db\DataProvider\QueryBuilder\Mysql;


use engine\db\DataProvider\QueryBuilder\Interface\IQueryBuilderFrom;
use engine\db\DataProvider\QueryBuilder\Interface\IQueryBuilderWhere;

class MysqlQueryBuilderFrom implements IQueryBuilderFrom
{
	private $query;

	public function __construct($query){
		$this->query = $query;
	}
	
	public function from($table): IQueryBuilderWhere
    {
		$this->query .= "FROM ".$table." ";
		return new MysqlQueryBuilderWhere($this->query);
	}

}

<?php

namespace engine\db\DataProvider;

class DataProviderFrom
{
	private $query;

	public function __construct($query){
		$this->query = $query;
	}
	
	public function from($table){
		$this->query .= "FROM ".$table." ";
		return new DataProviderWhere($this->query);
	}

}

<?php

namespace engine\widgets\NEWS;

use engine\core\exceptions as Exceptions;
use engine\db\DataProvider\DataProviderWhere;

class NEWS
{
	public $model;
	public $fieldList;
	public $template;
	public $title;

	private DataProviderWhere $dataProvider;
	private $searchModel;

	public function __construct($param){
		$this->parseParam($param);
		$this->printNews();
		return $this->title;
	}
	
	public function setSearchModel($params){
		if(is_array($params) && isset($params['searchModel'])){
			$this->searchModel = $params['searchModel'];
		}
		else throw new Exceptions\ParameterNotFoundException("searchModel");
	}
	
	public function setDataProvider($params){
		if(is_array($params) && isset($params['dataProvider'])){
			$this->dataProvider = $params['dataProvider'];
		}
		else throw new Exceptions\ParameterNotFoundException("dataProvider");
	}

	private function parseParam($p){
		$this->setSearchModel($p);
		$this->setDataProvider($p);
		$this->template = $p['template'];
	}
	
	private function parseField($list){
		$l = array();
		foreach($list as $key => $value){
			$l[] = explode(":", $value)[0];
		}
		return $l;
	}
	
	public function printNews(){
		$rows = $this->dataProvider->exe($this->searchModel);
		if($rows){
			foreach($rows as $article){
				echo $article->content;
				$this->title = $article->title;
			}	
		}
	}

}

?>
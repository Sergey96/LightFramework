<?php

namespace engine\widgets\GridView;

use engine\core\exceptions as Exceptions;
use engine\WebApp;

class GridView
{
	public $model;
	public $fieldList;
	public $actions;
	public $templateTable = "
		<table {id} {class}>\n{header}
			\n{rows}
		\t</table>\n";
	public $templateActionsHeader = [
		'view'=>"<th class='table-icon'>&#128065;</th>",
		'update'=>"<th class='table-icon'>&#x270e;</th>",
		'delete'=>"<th class='table-icon'>&#x2718;</th>"
		];
	public $templateHeader = "<th>{headers}</th>";
	public $templateRow = "\t\t<tr {id} {class}>\n{collumns}{actions}\n\t\t</tr>\n";
	public $templateCollumns = "\t\t\t<td {id} {class}>{value}</td>\n";
	public $templateActions = [
		'view'=>"<td><a href='/{controller}/view?id={id}'>view</a></td>",
		'update'=>"<td><a href='/{controller}/update?id={id}'>update</a></td>",
		'delete'=>"<td><a href='/{controller}/delete?id={id}'>del</a></td>"
	];
	public $RowsInPage = 25;
	
	public function __construct($param){
		$this->parseParam($param);
		$this->printTable();
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
		$this->fieldList = $this->parseField($p['fields']);
		if(isset($p['actions']))
			$this->actions = $p['actions'];
		else $this->actions = ['view', 'update', 'delete'];
	}
	
	private function parseField($list){
		$l = array();
		foreach($list as $key => $value){
			$l[] = explode(":", $value)[0];
		}
		return $l;
	}
	
	public function printTable(){
		$rows = array();
		$rows = $this->dataProvider->exe($this->searchModel);
		//$rows = $this->model->getData($this->fieldList, $this->RowsInPage);
		
		$HEADER = false;
		$headers = '';
		foreach($this->fieldList as $field){
			$headers .= str_replace("{headers}", $this->searchModel::$attributeLabels[$field][0], $this->templateHeader);
		}
		$actions = '';
		foreach($this->actions as $act)
			$actions .= $this->templateActionsHeader[$act];
		$headers .= $actions;
		
		$tr = "";
		foreach($rows as $row_key => $row){
			$td = "";
			$actions = '';
			foreach($this->fieldList as $field){
				$td .= str_replace("{value}", $row->$field, $this->templateCollumns);
			}
			$tr .= str_replace("{collumns}", $td, $this->templateRow);
			foreach($this->actions as $act)
				$actions .= str_replace("{id}", $row->id, $this->templateActions[$act]);
			$actions = str_replace("{controller}", WebApp::$controller->Name, $actions);
			$tr = str_replace("{actions}", $actions, $tr);
		}
		$table =  str_replace("{rows}", $tr, $this->templateTable);
		$table =  str_replace("{header}", $headers, $table);
		
		print_r($table);
	}

}

?>
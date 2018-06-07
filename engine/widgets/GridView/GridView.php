<?php

namespace engine\widgets\GridView;

use engine\base\Exceptions as Exceptions;
use engine\WebApp;

class GridView
{
	public $model;
	public $fieldList;
	public $templateTable = "<table {id} {class}>\n{header}<th>UPDATE</th><th><i class='icon-trash' title='Edit'> </i></th>\n{rows}\t</table>\n";
	public $templateHeader = "<th>{headers}</th>";
	public $templateRow = "\t\t<tr {id} {class}>\n{collumns}{actions}\n\t\t</tr>\n";
	public $templateCollumns = "\t\t\t<td {id} {class}>{value}</td>\n";
	public $templateActions = "<td><a href='/{controller}/update?id={id}'>update</a></td><td><a href='delete?id={id}'>delete</a></td>";
	public $RowsInPage = 25;
	
	public function __construct($param){
		$this->parseParam($param);
		$this->printTable();
	}
	
	public function setSearchModel($params){
		if(is_array($params) && isset($params['searchModel'])){
			echo "Нашел модель";
			$this->searchModel = $params['searchModel'];
		}
		else throw new Exceptions\ParameterNotFoundException("searchModel");
	}
	
	public function setDataProvider($params){
		if(is_array($params) && isset($params['dataProvider'])){
			echo "Нашел модель";
			$this->dataProvider = $params['dataProvider'];
		}
		else throw new Exceptions\ParameterNotFoundException("dataProvider");
	}

	private function parseParam($p){
		$this->setSearchModel($p);
		$this->setDataProvider($p);
		$this->fieldList = $this->parseField($p['fields']);
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
		$rows = $this->dataProvider->exe(get_parent_class($this->searchModel));
		//$rows = $this->model->getData($this->fieldList, $this->RowsInPage);
		
		$HEADER = false;
		$headers = '';
		foreach($this->fieldList as $field)
			$headers .= str_replace("{headers}", $field, $this->templateHeader);
		
		$tr = "";
		foreach($rows as $row_key => $row){
			$td = "";
			foreach($this->fieldList as $field){
				$td .= str_replace("{value}", $row->$field, $this->templateCollumns);
			}
			$tr .= str_replace("{collumns}", $td, $this->templateRow);
			$actions = str_replace("{id}", $row->id, $this->templateActions);
			$actions = str_replace("{controller}", WebApp::$controller->Name, $actions);
			$tr = str_replace("{actions}", $actions, $tr);
		}
		$table =  str_replace("{rows}", $tr, $this->templateTable);
		$table =  str_replace("{header}", $headers, $table);
		print_r($table);
	}
	
	public static function printBreadCrumbs($params){
		$bread = new BreadCrumbs();
		$html = '<ul>';
		
		foreach($params as $k => $v){
			if(is_array($v)){
				$u = str_replace("{url}", $v['url'], $bread->template);
				$l = str_replace("{label}", $v['label'], $u);
			}
			else {
				$l = str_replace("{label}", $v, $bread->templateNotLink);
			}
			$html .= $l;
		}
		$html .= '</ul>';
		print_r($html);
	}

}

?>
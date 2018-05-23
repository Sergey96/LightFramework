<?php

namespace engine\widgets;

class GridView
{
	public $model;
	public $fieldList;
	public $templateTable = "<table {id} {class}>{rows}</table>";
	public $templateRow = "<tr {id} {class}>{collumns}</tr>";
	public $templateCollumns = "<td {id} {class}>{value}</td>";
	
	public function __construct($param){
		$this->parseParam($param);
		$this->printTable();
	}
	
	public function setModel($inputModel){
		$this->model = $inputModel;
	}

	private function parseParam($p){
		$this->model = $p['model'];
		$this->fieldList = $this->parseField($p['fields']);
	}
	
	private function parseField($list){
		$l = array();
		foreach($list as $key => $value){
			$l[] = explode(":", $value);
		}
		return $l;
	}
	
	public function printTable(){
		$rows = array();
		$rows = $this->model->getData($this->fieldList);
		exit();
		foreach($rows as $row){
			$td ="";
			foreach($this->fieldList as $k => $field){
				$td .= str_replace("{value}", $row->$field[0], $this->templateCollumns);
			}
			print_r($td);
		}
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
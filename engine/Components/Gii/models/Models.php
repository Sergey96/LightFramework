<?php

namespace engine\Components\Gii\models;

use engine\WebApp;
use engine\base\Exceptions as Exceptions;
use engine\Models\Model;
use engine\Components\Gii\models\Column;

class Models extends Model
{
	public $tableName;
	public $className;
	public $nameSpace;
	public $parentClass;
	public $tablePrefix;
	public $isLabel;
	public $templateName;
	
	private $model;
	
	public function openTemplate(){
		$path = __DIR__ . '/';
		$filepath = __DIR__ . '/../' . $this->templateName . '.tmpl';
		if(file_exists($filepath))
			$this->model = file_get_contents($filepath);
		else 
			throw new Exceptions\FileNotFoundException($filepath);
	}
	
	public function insertValues(){
		$this->model = str_replace("###NAMESPACE###", $this->nameSpace, $this->model);
		$this->model = str_replace("###CLASS_NAME###", $this->className, $this->model);
		$this->model = str_replace("###PARENT_NAME###", $this->parentClass, $this->model);
		$this->model = str_replace("###TABLE_NAME###", $this->tableName, $this->model);
		try {
			$this->getTableColumns();
		} catch (\Exception $e){
			throw $e;
		}
		$stringToReplaceFields = '';
		$stringToReplaceLabels = '';
		$stringToReplacePHPDocsFields = '';
		$counter = 0;
		foreach($this->attributes_ as $column){
			$column->Type == "int(11)" ? $type = "int" : $type = $column->Type;
			$counter++;
			$stringToReplaceFields .= $this->getFieldsAsString($column->Field, $type);
			$stringToReplacePHPDocsFields .= $this->getPHPDocsAsString($column->Field, $type);
			
			$stringToReplaceLabels .= $this->getFieldsAsString($column->Field, mb_strtoupper($column->Field));
			if($column->Null=='NO')
				$stringToReplaceFields .= $this->getFieldsAsString($column->Field, 'required');
			//print_r($counter."::".count($this->attributes_)."\n");
			if($counter == count($this->attributes_)){
				$stringToReplaceFields = substr($stringToReplaceFields , 0, strlen($stringToReplaceFields)-2);
				$stringToReplaceLabels = substr($stringToReplaceLabels , 0, strlen($stringToReplaceLabels)-2);
			}
		}
		$this->model = str_replace("###CLASS_FIELDS###", $stringToReplaceFields, $this->model);
		$this->model = str_replace("###FIELDS_LABELS###", $stringToReplaceLabels, $this->model);
		$this->model = str_replace("###PHP_DOCS_PROPERTY###", $stringToReplacePHPDocsFields, $this->model);
		if(strlen($this->model)>0)
			return true;
		else return false;
	}
	
	private function getFieldsAsString($field, $param){
		return "\t\t[['$field'], '$param'],\n";
	}
	
	private function getPHPDocsAsString($field, $param){
		return " * @property $param $$field\n";
	}
	
	public function writeModel(){
		$filepath = WebApp::$home.$this->nameSpace."/".$this->className.'.php';

		if(file_exists($filepath))
			throw new Exceptions\FileExistsException($filepath);
		else 
			file_put_contents($filepath, $this->model);
	}
	
	
}
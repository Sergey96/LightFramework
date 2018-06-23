<?php

namespace engine\Components\Gii\models;

use engine\WebApp;
use engine\base\Exceptions as Exceptions;
use engine\Models\Model;
use engine\Components\Gii\models\Column;

/**
 * GII генерирование Моделей
 */
/// GII генерирование Моделей
class Models extends Model
{

	public static $attributeLabels =
	[
		'tableName' => ['TableName', 'text', 'required'],
		'className' => ['className', 'text', 'required'],
		'nameSpace' => ['nameSpace', 'text', 'required'],
		'parentClass' => ['parentClass', 'text', 'required'],
		'tablePrefix' => ['tablePrefix', 'text', 'required'],
		'isLabel' => ['isLabel', 'text', 'required'],
		'templateName' => ['templateName', 'text', 'required']
	];
	
	/**
	 * Имя таблицы связываемой с моделью
	 */
	public $tableName;
	
	/**
	 * Имя Класса Модели (ex. UsersModel)
	 */
	public $className;
		
	/**
	 * Пространство имен Модели
	 */
	public $nameSpace;
	
	/**
	 * Родительский класс
	 */
	public $parentClass;
		
	/**
	 * Префикс таблиц бд
	 */
	public $tablePrefix;
		
	/**
	 * Использовать метки из комментариев полей
	 */
	public $isLabel;
		
	/**
	 * Имя шаблона Модели
	 */
	public $templateName;
	
	/**
	 * Исходный код модели
	 * на каждом этапе хранится текущее состояние
	 * сначала загружается текст из шаблона
	 * постепенно заменяются метки в шаблоне на данные от пользователя
	 * либо поля из связанной таблицы
	 */
	private $model;
	
	/**
	 * Загружает исходный код шаблона в $this->model
	 * @throw FileNotFoundException Не Найден Файл Шаблона
	 */
	public function openTemplate(){
		$filepath = WebApp::$home."/engine/components/Gii/".$this->templateName.'.tpl';
		if(file_exists($filepath)){
			$this->model = file_get_contents($filepath);
		}
		else 
			throw new Exceptions\FileNotFoundException($filepath);
	}
	
	/**
	 * Заменяет основные метки, а также вставляет списки полей,
	 * полученные из связанной таблицы
	 */
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
		print_r($this->attributes_);
		exit();
		foreach($this->attributes_ as $column){
			$column->Type == "int(11)" ? $type = "int" : $type = $column->Type;
			$counter++;
			$stringToReplaceFields .= $this->getFieldsAsString($column->Field);
			$stringToReplacePHPDocsFields .= $this->getPHPDocsAsString($column->Field, $type);
			
			if($column->Null=='NO'){
				if($column->Extra=='auto_increment')
					$stringToReplaceLabels .= $this->getPropertiesAsString($column->Field, mb_strtoupper($column->Field), $type, 'autoincrement');
				else
					$stringToReplaceLabels .= $this->getPropertiesAsString($column->Field, mb_strtoupper($column->Field), $type, 'required');
				}
			else
				$stringToReplaceLabels .= $this->getPropertiesAsString($column->Field, mb_strtoupper($column->Field), $type);
			
			if($counter == count($this->attributes_)){
				$stringToReplaceFields = substr($stringToReplaceFields , 0, strlen($stringToReplaceFields)-1);
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
	
	/**
	 * Шаблон свойства модели
	 */
	private function getFieldsAsString($field){
		return "\tpublic $$field;\n";
	}
	
	/**
	 * Шаблон правил валидации модели
	 */
	private function getPropertiesAsString($field, $param, $type, $required = false){
		if($required===false)
			return "\t\t'$field' => ['$param', '$type'],\n";
		else
			return "\t\t'$field' => ['$param', '$type', '$required'],\n";
	}
	
	/**
	 * Шаблон PHPDocs
	 */
	private function getPHPDocsAsString($field, $param){
		return " * @property $param $$field\n";
	}
	
	/**
	 * Записывает получившийся код модели в конечную папку
	 * @throw FileExistsException Файл Уже Существует (данные не перезаписываются)
	 */
	public function writeModel(){
		$filepath = str_replace("\\", "/", WebApp::$home.'/'.$this->nameSpace."/".$this->className.'.php');

		if(file_exists($filepath))
			throw new Exceptions\FileExistsException($filepath);
		else 
			file_put_contents($filepath, $this->model);
	}
		
}
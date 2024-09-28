<?php

namespace engine\components\gii\models;

use engine\App;
use engine\core\exceptions as Exceptions;
use engine\base\models\Model;

class Views extends Model
{

	public static $attributeLabels =
	[
		'ModelName' => ['ModelName', 'text', 'required'],
		'SearchModelName' => ['SearchModelName', 'text', 'required'],
		'ModelNamespace' => ['ModelNamespace', 'text', 'required'],
		'ControllerName' => ['ControllerName', 'text', 'required'],
		'ControllerNamespace' => ['ControllerNamespace', 'text', 'required'],
		'ViewPath' => ['ViewPath', 'text', 'required'],
		'ControllerTpl' => ['ControllerTpl', 'text', 'required'],
		'SearchModelTpl' => ['SearchModelTpl', 'text', 'required'],
		'IndexTpl' => ['IndexTpl', 'text', 'required'],
		'CreateTpl' => ['CreateTpl', 'text', 'required'],
		'UpdateTpl' => ['UpdateTpl', 'text', 'required'],
		'ViewTpl' => ['ViewTpl', 'text', 'required'],
		'FormTpl' => ['FormTpl', 'text', 'required'],
	];
	/// Имя модели
	public $ModelName;
	/// Имя Search модели
	public $SearchModelName;
	/// Пространство имен модели
	public $ModelNamespace;
	/// Имя контроллера
	public $ControllerName;
	/// Пространство имен контроллера
	public $ControllerNamespace;
	/// Директория views - представления
	public $ViewPath;
	/// Шаблон контроллера
	public $ControllerTpl;
	/// Шаблон SearchModel
	public $SearchModelTpl;
	/// Шаблон представнения - index
	public $IndexTpl;
	/// Шаблон представнения - create
	public $CreateTpl;
	/// Шаблон представнения - update
	public $UpdateTpl;
	/// Шаблон представнения - view
	public $ViewTpl;
	/// Шаблон представнения - _form
	public $FormTpl;
	
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
	public function openTemplate($file){
		$filepath = App::$home."/engine/components/Gii/".$file.'.tpl';
		if(file_exists($filepath)){
			$this->model = file_get_contents($filepath);
		}
		else 
			throw new Exceptions\FileNotFoundException($filepath);
	}
	
	/**
	 * Открывает, Заполняет, Сохраняет код контроллера
	 */
	public function generateController(){
		$this->openTemplate($this->ControllerTpl);
		$this->insertControllerValues();
		$this->writeModel($this->ControllerNamespace, $this->ControllerName);
	}
	
	/**
	 * Открывает, Заполняет, Сохраняет код контроллера
	 */
	public function generateSearchModel(){
		$this->openTemplate($this->SearchModelTpl);
		$this->insertSearchModelValues();
		$this->writeModel($this->ModelNamespace.'\\SearchModels', $this->SearchModelName);
	}
	
	/**
	 * Подставляет данные в шаблон контроллера
	 */
	private function insertControllerValues(){
		$this->model = str_replace("###CONTROLLER_NAMESPACE###", $this->ControllerNamespace, $this->model);
		$this->model = str_replace("###CONTROLLER_NAME###", $this->ControllerName, $this->model);
		$this->model = str_replace("###CONTROLLER###", strtolower($this->ControllerName), $this->model);
		$this->model = str_replace("###MODEL_NAMESPACE###", $this->ModelNamespace, $this->model);
		$this->model = str_replace("###MODEL_NAME###", $this->ModelName, $this->model);
		$this->model = str_replace("###SEARCH_CLASS_NAME###", $this->SearchModelName, $this->model);
	}
	
	/**
	 * Подставляет данные в шаблон контроллера
	 */
	private function insertSearchModelValues(){
		$this->model = str_replace("###NAMESPACE###", $this->ModelNamespace.'\\SearchModels', $this->model);
		$this->model = str_replace("###CLASS_NAME###", $this->ModelName, $this->model);
		$this->model = str_replace("###SEARCH_CLASS_NAME###", $this->SearchModelName, $this->model);
	}
	
	/**
	 * Открывает, Заполняет, Сохраняет шаблон представления - index
	 */
	public function generateViewsIndex(){
		$this->openTemplate($this->IndexTpl);
		$this->insertIndexValues();
		$this->writeModel($this->ViewPath, 'index');
	}
		
	/**
	 * Открывает, Заполняет, Сохраняет шаблон представления - error
	 */
	public function generateViewsError(){
		$this->openTemplate('/templates/ViewsErrorTemplate');
		$this->writeModel($this->ViewPath, 'error');
	}
		
	/**
	 * Открывает, Заполняет, Сохраняет шаблон представления - create
	 */
	public function generateViewsCreate(){
		$this->openTemplate($this->CreateTpl);
		$this->writeModel($this->ViewPath, 'create');
	}
		
	/**
	 * Открывает, Заполняет, Сохраняет шаблон представления - view
	 */
	public function generateViewsView(){
		$this->openTemplate($this->ViewTpl);
		$this->writeModel($this->ViewPath, 'view');
	}
		
	/**
	 * Открывает, Заполняет, Сохраняет шаблон представления - update
	 */
	public function generateViewsUpdate(){
		$this->openTemplate($this->CreateTpl);
		$this->writeModel($this->ViewPath, 'update');
	}
		
	/**
	 * Открывает, Заполняет, Сохраняет шаблон представления - _form
	 */
	public function generateViewsForm(){
		$this->openTemplate($this->FormTpl);
		$this->insertFormValues();
		$this->writeModel($this->ViewPath, '_form');
	}
	
	/**
	 * Подставляет данные в шаблон представления - _form
	 * получает список полей из БД
	 */
	public function insertFormValues(){
		$this->model = str_replace("###CONTROLLER_NAME###", $this->ControllerName, $this->model);
		$ReplaceFields = '';
		$counter = 0;
		//print_r($this->attributes_);
		foreach($this->attributes_ as $column){
			switch($column->Type){
				case 'int(11)': 
					$ReplaceFields .= $this->getFieldsTextInput($column->Field, 'textInput'); 
					break;
				case 'datetime': 
					$ReplaceFields .= $this->getFieldsTextInput($column->Field, 'textInput'); 
					break;
				case 'text': 
					$ReplaceFields .= $this->getFieldsTextInput($column->Field, 'textarea'); 
					break;
			}
		}
		$ReplaceFields = substr($ReplaceFields, 0, strlen($ReplaceFields)-1);
		$this->model = str_replace("###FIELDS###", $ReplaceFields, $this->model);
		if(strlen($this->model)>0)
			return true;
		else return false;
	}
	
	/**
	 * Подставляет данные в шаблон представления - index
	 * получает список полей из БД
	 */
	public function insertIndexValues(){
		$this->model = str_replace("###CONTROLLER_NAME###", strtolower($this->ControllerName), $this->model);
		$ReplaceFields = '';
		$counter = 0;
		foreach($this->attributes_ as $column){
			$column->Type == "int(11)" ? $type = "int" : $type = $column->Type;
			$ReplaceFields .= $this->getFieldsForGRID($column->Field, $type); 
		}
		$ReplaceFields = substr($ReplaceFields, 0, strlen($ReplaceFields)-1);
		$this->model = str_replace("###FIELDS###", $ReplaceFields, $this->model);
		if(strlen($this->model)>0)
			return true;
		else return false;
	}
			
	/**
	 * Шаблон для поля в index ('id:int')
	 */
	private function getFieldsForGRID($field, $type){
		return "\t\t\t\t'".$field.':'.$type."',\n";
	}
	
	/**
	 * Шаблон для поля в _form (<?= $form->field($model, 'id')->textInput() ?>)
	 */
	private function getFieldsTextInput($field, $function){
		return "\t\t<?= \$form->field(\$model, '$field')->$function() ?>\n";
	}

	/**
	 * Записывает получившийся код в конечную папку
	 * @throw FileExistsException Файл Уже Существует (данные не перезаписываются)
	 */
	public function writeModel($path, $file){
		$path = str_replace("\\", "/", App::$home.'/'.$path."/");
		if(!is_dir($path))
			mkdir($path);
		$filepath = $path.$file.'.php';
		if(file_exists($filepath))
			throw new Exceptions\FileExistsException($filepath);
		else 
			file_put_contents($filepath, $this->model);
	}
	
	
}
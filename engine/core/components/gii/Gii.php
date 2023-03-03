<?php

namespace engine\components\Gii;

use engine\WebApp;
use engine\core\exceptions as Exceptions;
use engine\base\controllers\Controller;
use engine\Components\Gii\models\Models;
use engine\Components\Gii\models\Views;

/**
 * Gii автогенератор кода
 */
/// Gii автогенератор кода
class Gii extends Controller
{

	/**
	 * Права доступа
	 */
	public function accessRights()
	{
		return 
		[
			'access'=>[
				[
					'allow' => true,
					'actions' => ['index', 'models', 'crud', 'generate', 'view'],
					'roles' => ['dev'],
				],
				[
					'allow' => false,
					'actions' => ['index', 'models', 'crud', 'generate', 'view'],
					'roles' => ['*'],
				]
			],
			'redirect' => [
				'controller'=>'home', 
				'view'=>'login'
			]
		];
	}
	
	/**
	 * Папка представления (относительно web/index.php файла)
	 */
	public $ViewPath  = '../../engine/components/Gii/views/';

	/**
	 * action - действие по-умолчанию
	 */
	public function action(){
	    return $this->render("index");
    }
	
	/**
	 * action - Генератор Моделей
	 */
	public function actionModels(){
	    return $this->render("models");
    }
	
	/**
	 * action - Генератор CRUD операций
	 * Файлы
	 * - controllers/Controller.php
	 * - views/controller_name/index.php
	 * - views/controller_name/create.php
	 * - views/controller_name/view.php
	 * - views/controller_name/update.php
	 * - views/controller_name/_form.php
	 * - views/controller_name/error.php
	 */
	public function actionCrud(){
	    return $this->render("crud");
    }
	
	/**
	 * action - Выбор режима генератора
	 */
	public function actionGenerate($type){
		switch($type){
			case "models": $this->genModels(); break;
			case "crud": $this->genCRUD(); break;
			default: throw new Exceptions\ArgumentNotFoundException('$type'); break;
		}
	}
	
	/**
	 * action - Выбор режима генератора
	 */
	public function actionView($type){
		switch($type){
			case "models": $this->viewModels(); break;
			case "crud": $this->viewModels(); break;
			default: throw new Exceptions\ArgumentNotFoundException('$type'); break;
		}
	}
	
	/**
	 * отображает исходный код сгенерированного файла
	 */
	private function viewModels(){
		$path = WebApp::$home.'/'.WebApp::$request->get()['file'].'.php';
		$file = file_get_contents($path);
		$file = substr($file, 5);
		$this->render('view', [
			'file'=>$file,
			'filepath'=>$path
		]);
	}
	
	/**
	 * генерирует модели
	 * - если не передано имя таблицы - redirect(gii/models)
	 * - по окончании отображается исходный код полученного файла
	 */
	private function genModels(){
		$model = new Models();
		if(isset(WebApp::$request->post()['tableName'])){
			$model->setTableName(WebApp::$request->post()['tableName']);
		} else {
			$this->redirect(['models']);
		}
		if ($model->load(WebApp::$request->post())){
			
			$model->openTemplate();
			if($model->insertValues()){
				$model->writeModel();
				$this->redirect(['view', 'type'=>'models', 'file'=>$model->nameSpace."/".$model->className], 'gii');
			}
		}
		else {
			$this->redirect(['models']);
		}
	}
	
	/**
	 * генерирует контроллер и список представлений
	 * по окончании отображается исходный код Контроллера
	 */
	private function genCRUD(){
		$model = new Views();
		$model->load(WebApp::$request->post());
		if (!$model->getErrorsLoad()){
			$Model = $model->ModelNamespace.'\\'.$model->ModelName;
			$table = new $Model();
			$model->setTableName($table->Table);
			$model->ViewPath .= '/'.strtolower($model->ControllerName);
			$model->getTableColumns();
			$model->generateController();
			$model->generateSearchModel();
			$model->generateViewsForm();
			$model->generateViewsIndex();
			$model->generateViewsError();
			$model->generateViewsView();
			$model->generateViewsCreate();
			$model->generateViewsUpdate();
			$this->redirect(['view', 'type'=>'models', 'file'=>$model->ControllerNamespace."/".$model->ControllerName], 'gii');
		}
		else {
			print_r($model->getErrorsLoad());
			exit();
			$this->redirect(['crud'], 'gii');
		}
	}
}

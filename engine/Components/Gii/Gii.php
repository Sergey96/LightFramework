<?php

namespace engine\components\Gii;
use engine\WebApp;
use engine\base\Exceptions as Exceptions;
use engine\Controller\Controller;
use engine\Components\Gii\models\Models;

class Gii extends Controller
{
	public $ViewPath  = '../../engine/Components/Gii/views/';

	public function action(){
	    $this->render("index");
    }
	
	 /// TODO Удалить нафиг
	public function actionПривет(){
		$this->render("index");
	}
	
	public function actionModels(){
	    $this->render("models");
    }
	
	public function actionGenerate($type){
		switch($type){
			case "models": $this->genModels(); break;
			case "crud": echo "Генерим CRUD Generate"; break;
			default: throw new Exceptions\ArgumentNotFoundException('$type'); break;
		}
	}
	
	public function actionView($type, $file){
		switch($type){
			case "models": $this->viewModels($file); break;
			case "crud": echo "Генерим CRUD Generate"; break;
			default: throw new Exceptions\ArgumentNotFoundException('$type'); break;
		}
	}
	
	private function viewModels($file){
		$path = WebApp::$home.WebApp::$request->get()['file'].'.php';
		$file = file_get_contents($path);
		$file = substr($file, 5);
		$this->render('view', [
			'file'=>$file
		]);
	}
	
	private function genModels(){
		$model = new Models();
		if(isset(WebApp::$request->post()['tableName'])){
			$model->setTableName(WebApp::$request->post()['tableName']);
		} else {
			$this->redirect(['models']);
		}
		
		if ($model->loadData(WebApp::$request->post())){
			try {
				$model->openTemplate();
			}
			catch (Exceptions\FileNotFoundException $e){
				throw $e;
			}
			if($model->insertValues()){
				$model->writeModel();
				$this->redirect(['view', 'type'=>'models', 'file'=>$model->nameSpace."/".$model->className]);
			}
		}
		else {
			$this->redirect(['models']);
		}
		
	}
	
	/**
     * Функция рендеринга представления
     *
     * @return string
     */
	public function render($view, $param = array()){
		$layout = $this->ViewPath.'/layout/'.$this->Layout;
		$view = $this->ViewPath ."/$view.php";
		try{
			$content = $this->getContentView($view, $param);
			require_once $layout;
		}
		catch (\Exeption $e){
			echo 'Не найден файл';
		}
	}
}

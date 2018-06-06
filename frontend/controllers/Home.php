<?php

namespace frontend\controllers;

use engine\Controller\Controller;
use frontend\models\FilmsModel;
use frontend\models\ArticleModel;
use engine\WebApp;

class Home extends Controller
{
	
	public function __construct($u){
		parent::__construct($u);
	}
	
	public function action(){
		$model = new ArticleModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionIndex(){
		$model = new ArticleModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionAll(){
		$this->render('all', ['model'=>'aaaa']);
	}
	
	public function actionUpdate($id){
		$model = new FilmsModel();
		//if($model->load(WebApp::$request->post())){
		if(WebApp::$request->post()){
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$model = $model->getByID($id);
			$this->render('update', ['model'=>$model]);
		}
	}
	
	
	public function actionView($id){
		/// TODO: Сделать свойство Table статическим
		$model = new FilmsModel();
		$model = $model->getByID($id);
		$this->render('view', ['model'=>$model]);
	}
	
}

?>
<?php

namespace frontend\controllers;

use engine\Controller\Controller;
use frontend\models\FilmsModel;
use engine\WebApp;

class Films extends Controller
{
	
	public function action(){
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionIndex(){
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionCreate(){
		$model = new FilmsModel();
		$this->render('create', ['model'=>$model]);
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
	
}
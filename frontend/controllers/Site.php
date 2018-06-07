<?php

namespace frontend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use frontend\models\FilmsModel;

class Site extends Controller
{
	
	public function action(){
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionIndex(){
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionUpdate($id){
		$model = new FilmsModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$model = $model->findOne($id);
			$this->render('update', ['model'=>$model]);
		}
	}
	
	public function actionCreate(){
		$model = new FilmsModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$this->render('create', ['model'=>$model]);
		}
	}
	
	public function actionView($id){
		$model = new FilmsModel();
		$model = $model->findOne($id);
		$this->render('view', ['model'=>$model]);
	}
	
	public function actionView($id){
		$model = new FilmsModel();
		$model = $model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

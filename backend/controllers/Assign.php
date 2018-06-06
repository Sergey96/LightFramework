<?php

namespace backend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use backend\models\AssignRolesModel;

class Assign extends Controller
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
					'actions' => ['index', 'create', 'update', 'view', 'delete'],
					'roles' => ['dev', 'admin'],
				],
				[
					'allow' => false,
					'actions' => ['index', 'create', 'update', 'view', 'delete'],
					'roles' => ['*'],
				]
			],
			'redirect' => [
				'controller'=>'home', 
				'view'=>'login'
			]
		];
	}
	public function action(){
		$model = new AssignRolesModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionIndex(){
		$model = new AssignRolesModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionUpdate($id){
		$model = new AssignRolesModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$model = $model->getByID($id);
			$this->render('update', ['model'=>$model]);
		}
	}
	
	public function actionCreate(){
		$model = new AssignRolesModel();
		$model->load(WebApp::$request->post());
		if(!$model->getErrorsLoad()){
			$model->save();
			$this->redirect(['index']);
		}
		else {
			$this->render('create', ['model'=>$model]);
		}
	}
	
	public function actionView($id){
		$model = new AssignRolesModel();
		$model = $model->getByID($id);
		$this->render('view', ['model'=>$model]);
	}
	
	public function actionDelete($id){
		$model = new AssignRolesModel();
		$model = $model->getByID($id)->delete();
		$this->redirect(['index']);
	}
	
}

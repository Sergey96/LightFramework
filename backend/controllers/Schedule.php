<?php

namespace backend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use backend\models\ScheduleModel;
use backend\models\SearchModels\ScheduleSearchModel;

/**
 * Schedule - backend\controllers Контроллер
 */
/// Schedule - backend\controllers Контроллер
class Schedule extends Controller
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
					'actions' => ['index', 'create', 'update', 'view', 'delete', 'error'],
					'roles' => ['admin'],
				],
				[
					'allow' => true,
					'actions' => ['login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'actions' => ['index', 'view', 'error'],
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
	 * action - Главная страница
	 */
	public function actionIndex(){
		$searchModel = new ScheduleSearchModel();
		$dataProvider = $searchModel->search(WebApp::$request->get());
		$this->render('index', [
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModel
		]);
	}
	
	/**
	 * action - Обновить запись
	 */
	public function actionUpdate($id){
		$model = new ScheduleModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$model = $model->getByID($id);
			$this->render('update', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Создать запись
	 */
	public function actionCreate(){
		$model = new ScheduleModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['index']);
		}
		else {
			$this->render('create', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Просмотреть запись
	 */
	public function actionView($id){
		$model = new ScheduleModel();
		$model = $model->getByID($id);
		$this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new ScheduleModel();
		$model = $model->getByID($id)->delete();
		$this->redirect(['index']);
	}
	
}

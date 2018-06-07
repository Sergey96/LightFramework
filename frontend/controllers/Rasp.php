<?php

namespace frontend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use frontend\models\ScheduleModel;
use frontend\models\SearchModels\ScheduleSearchModel;

/**
 * Rasp - frontend\controllers Контроллер
 */
/// Rasp - frontend\controllers Контроллер
class Rasp extends Controller
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
					'actions' => ['groups', 'create', 'update', 'view', 'delete', 'error'],
					'roles' => ['admin'],
				],
				[
					'allow' => true,
					'actions' => ['groups', 'login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'actions' => ['groups', 'index', 'view', 'error'],
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
	 * action - действие по-умолчанию
	 */
	public function action(){
		$model = new ScheduleModel();
		$this->render('index', ['model'=>$model]);
	}

	/**
	 * action - Главная страница
	 */
	public function actionGroups(){
		$searchModel = new ScheduleSearchModel();
		$dataProvider = $searchModel->search(WebApp::$request->get());
		$this->render('view', [
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
			$model = $model->findOne($id);
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
		$model = $model->findOne($id);
		$this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new ScheduleModel();
		$model = $model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

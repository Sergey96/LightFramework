<?php

namespace ###CONTROLLER_NAMESPACE###;

use engine\WebApp;
use engine\Controller\Controller;
use ###MODEL_NAMESPACE###\###MODEL_NAME###;
use ###MODEL_NAMESPACE###\SearchModels\###SEARCH_CLASS_NAME###;

/**
 * ###CONTROLLER_NAME### - ###CONTROLLER_NAMESPACE### Контроллер
 */
/// ###CONTROLLER_NAME### - ###CONTROLLER_NAMESPACE### Контроллер
class ###CONTROLLER_NAME### extends Controller
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
		$searchModel = new ###SEARCH_CLASS_NAME###();
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
		$model = new ###MODEL_NAME###();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$model = $model->findOne($id);
			$this->render('update', [
				'model'=>$model,
			]);
		}
	
	/**
	 * action - Создать запись
	 */
	public function actionCreate(){
		$model = new ###MODEL_NAME###();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['index']);
		}
		else {
			$this->render('create', [
				'model'=>$model,
			]);
		}
	}
		
		
		$model->load(WebApp::$request->post());
		if(!$model->getErrorsLoad()){
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$error = $model->getErrorsLoad();
			$model = $model->findOne($id);
			$this->render('update', [
				'model'=>$model, 
				'error'=>$error
			]);
		}
		
		
	}
	
	/**
	 * action - Просмотреть запись
	 */
	public function actionView($id){
		$model = new ###MODEL_NAME###();
		$model = $model->findOne($id);
		$this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new ###MODEL_NAME###();
		$model = $model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

<?php

namespace backend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use backend\models\UsersModel;
use backend\models\SearchModels\UsersSearchModel;
use engine\Components\AccessManager;

/**
 * Users - backend\controllers Контроллер
 */
/// Users - backend\controllers Контроллер
class Users extends Controller
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
					'actions' => ['index', 'create', 'update', 'view', 'delete', 'error', 'changepass'],
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
		$searchModel = new UsersSearchModel();
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
		$model = new UsersModel();
		if($model->load(WebApp::$request->post())){
			$
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$model = $model->findOne($id);
			$this->render('update', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Обновить запись
	 */
	public function actionChangepass($id){
		$model = new UsersModel();
		if(isset(WebApp::$request->post()['password'])){
			$model = $model->findOne($id);
			$model->password = AccessManager::encryptPassword(WebApp::$request->post()['password']);
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$model = $model->findOne($id);
			$this->render('ChangePass', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Создать запись
	 */
	public function actionCreate(){
		$model = new UsersModel();
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
		$model = new UsersModel();
		$model = $model->findOne($id);
		$this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new UsersModel();
		$model = $model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

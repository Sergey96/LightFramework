<?php

namespace backend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use backend\models\UsersModel;
use engine\components\AccessManager;


/**
 * Users контроллер
 */
/// Users контроллер
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
					'actions' => ['index', 'create', 'update', 'view', 'delete'],
					'roles' => ['dev', 'admin'],
				],
				[
					'allow' => true,
					'actions' => ['login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => false,
					'actions' => ['index', 'create', 'update', 'view', 'delete', 'error'],
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
		$model = new UsersModel();
		$this->render('index', ['model'=>$model]);
	}
	
	/**
	 * action - Главная страница
	 */
	public function actionIndex(){
		$model = new UsersModel();
		$this->render('index', ['model'=>$model]);
	}
	
	/**
	 * action - Обновить запись
	 */
	public function actionUpdate($id){
		$model = UsersModel::findByID($id);
		if($model->load(WebApp::$request->post())){
			$model->password = AccessManager::encryptPassword($model->password);
			$model->token = ' ';
			$model->save();
			$this->redirect(['view', 'id'=>$id]);
		}
		else {
			$this->render('update', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Создать запись
	 */
	public function actionCreate(){
		$model = new UsersModel();
		if($model->load(WebApp::$request->post())){
			$model->password = AccessManager::encryptPassword($model->password);
			$model->token = ' ';
			$model->save();
			$this->redirect(['index']);
		}
		else {
			$this->render('create', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Просмотр записи
	 */
	public function actionView($id){
		$model = new UsersModel();
		$model = $model->getByID($id);
		$this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new UsersModel();
		$model = $model->getByID($id)->delete();
		$this->redirect(['index']);
	}
	
}

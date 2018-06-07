<?php

namespace backend\controllers;

use engine\Controller\Controller;
use backend\models\FilmsModel;
use backend\models\LoginFormModel;
use engine\WebApp;

/**
 * Home контроллер по-умолчанию
 */
/// Home контроллер по-умолчанию
class Home extends Controller
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
					'actions' => ['index', 'create', 'update', 'view', 'delete', 'logout'],
					'roles' => ['dev', 'admin'],
				],
				[
					'allow' => true,
					'actions' => ['login', 'error', 'logout'],
					'roles' => ['?'],
				],
				[
					'allow' => false,
					'actions' => ['index', 'create', 'update', 'view', 'delete', 'logout'],
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
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	/**
	 * action - Главная страница
	 */
	public function actionIndex(){
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	/**
	 * action - Обновить запись
	 */
	public function actionUpdate($id){
		$model = new FilmsModel();
		//if($model->load(WebApp::$request->post())){
		if(WebApp::$request->post()){
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
	public function actionView($id){
		/// TODO: Сделать свойство Table статическим
		$model = new FilmsModel();
		$model = $model->findOne($id);
		$this->render('view', ['model'=>$model]);
	}
		
	/**
	 * Авторизация
	 */
	public function actionLogin(){
		$model = new LoginFormModel();
		if($model->load(WebApp::$request->post()) && $model->login()){
			$this->redirect(['index'], 'home');
		}
		else {
			$this->render('login', ['model'=>$model]);
		}
	}
		
	/**
	 * Выход из аккаунта
	 */
	public function actionLogout(){
		WebApp::$user->logout();
		$this->redirect(['index'], 'home');
	}
	
}

?>
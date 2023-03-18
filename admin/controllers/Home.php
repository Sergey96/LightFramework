<?php

namespace admin\controllers;

use engine\Controller\Controller;
use admin\models\ArticleModel;
use admin\models\LoginFormModel;
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
					'actions' => ['index', 'create', 'update', 'view', 'delete', 'logout', 'error'],
					'roles' => ['admin', '*'],
				],
				[
					'allow' => true,
					'actions' => ['login', 'error'],
					'roles' => ['?'],
				],
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
        return $this->render('index', ['model'=>$model]);
	}
	
	/**
	 * action - Главная страница
	 */
	public function actionIndex(){
		$model = new FilmsModel();
        return $this->render('index', ['model'=>$model]);
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
            return $this->render('update', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Создать запись
	 */
	public function actionView($id){
		/// TODO: Сделать свойство Table статическим
		$model = new FilmsModel();
		$model = $model->findOne($id);
        return $this->render('view', ['model'=>$model]);
	}
		
	/**
	 * Авторизация
	 */
	public function actionLogin(){
		$model = new LoginFormModel();
		if($model->load(WebApp::$request->post()) && $model->login()){
			$this->redirect(['index']);
		}
		else {
            return $this->render('login', ['model'=>$model]);
		}
	}
		
	/**
	 * Выход из аккаунта
	 */
	public function actionLogout(){
		WebApp::$user->logout();
        return $this->redirect(['index'], 'home');
	}
	
}

?>
<?php

namespace backend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use backend\models\AccessRolesModel;
/**
 * Access - Контроллер
 */
class Access extends Controller
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

	/**
	 * action по-умолчанию
	 */
	public function action(){
		$model = new AccessRolesModel();
		$this->render('index', ['model'=>$model]);
	}
	
	/**
	 * action - Главная страница
	 */
	public function actionIndex(){
		$model = new AccessRolesModel();
		$this->render('index', ['model'=>$model]);
	}

	/**
	 * action - Обновить запись
	 */
	public function actionUpdate($id){
		$model = new AccessRolesModel();
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
		$model = new AccessRolesModel();
		if($model->load(WebApp::$request->post())){
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
		$model = new AccessRolesModel();
		$model = $model->getByID($id);
		$this->render('view', ['model'=>$model]);
	}

	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new AccessRolesModel();
		$model = $model->getByID($id)->delete();
		$this->redirect(['index']);
	}
	
}

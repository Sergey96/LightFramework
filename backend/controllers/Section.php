<?php

namespace backend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use engine\widgets\Sidebar\models\SectionModel;

/**
 * Section - backend\controllers Контроллер
 */
/// Section - backend\controllers Контроллер
class Section extends Controller
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
	 * action - действие по-умолчанию
	 */
	public function action(){
		$model = new SectionModel();
		$this->render('index', ['model'=>$model]);
	}

	/**
	 * action - Главная страница
	 */
	public function actionIndex(){
		$model = new SectionModel();
		$this->render('index', ['model'=>$model]);
	}
	
	/**
	 * action - Обновить запись
	 */
	public function actionUpdate($id){
		$model = new SectionModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['view', 'id'=>$id], $this->name);
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
		$model = new SectionModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['index'], 'section');
		}
		else {
			$this->render('create', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Просмотреть запись
	 */
	public function actionView($id){
		$model = new SectionModel();
		$model = $model->getByID($id);
		$this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new SectionModel();
		$model = $model->getByID($id)->delete();
		$this->redirect(['index'], $this->name);
	}
	
}

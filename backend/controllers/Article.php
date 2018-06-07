<?php

namespace backend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use backend\models\ArticleModel;
use backend\models\SearchModels\ArticleSearchModel;

/**
 * Article - backend\controllers Контроллер
 */
/// Article - backend\controllers Контроллер
class Article extends Controller
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
		$searchModel = new ArticleSearchModel();
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
		$model = new ArticleModel();
		$model->load(WebApp::$request->post());
		//print_r($model->getErrorsLoad());
		//exit();
		if(!$model->getErrorsLoad()){
			$model->setNotNew();
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
		$model = new ArticleModel();
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
		$model = new ArticleModel();
		$model = $model->findOne($id);
		$this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new ArticleModel();
		$model = $model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

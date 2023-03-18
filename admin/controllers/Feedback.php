<?php

namespace admin\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use admin\models\FeedbackModel;
use admin\models\SearchModels\FeedbackSearchModel;
use engine\core\exceptions as Exceptions;

/**
 * Feedback - admin\controllers Контроллер
 */
/// Feedback - admin\controllers Контроллер
class Feedback extends Controller
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
		$searchModel = new FeedbackSearchModel();
		$dataProvider = $searchModel->search(WebApp::$request->get());
        return $this->render('index', [
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModel
		]);
	}
	
	/**
	 * action - Обновить запись
	 */
	public function actionUpdate($id){
		$model = new FeedbackModel();
		if($model->load(WebApp::$request->post())){
			if(isset(WebApp::$request->post()['_csrf']) && 
				strcmp(WebApp::$request->post()['_csrf'], WebApp::$user->token) == 0){
				$model->save();
				$this->redirect(['view', 'id'=>$id]);
			}
			else throw new Exceptions\CSRFDetectedException('_csrf токены не совпадают');
		}
		else {
			$model = $model->findOne($id);
            return $this->render('update', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Создать запись
	 */
	public function actionCreate(){
		$model = new FeedbackModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['index']);
		}
		else {
            return $this->render('create', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Просмотреть запись
	 */
	public function actionView($id){
		$model = new FeedbackModel();
		$model = $model->findOne($id);
        return $this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new FeedbackModel();
		$model = $model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

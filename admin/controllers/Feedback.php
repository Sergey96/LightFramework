<?php

namespace admin\controllers;

use engine\App;
use engine\base\controllers\Controller;
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
	public function accessRights(): array
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
	public function actionIndex(): string
    {
		$searchModel = new FeedbackSearchModel();
		$dataProvider = $searchModel->search(App::$request->get());
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
		if($model->load(App::$request->post())){
			if(isset(App::$request->post()['_csrf']) &&
				strcmp(App::$request->post()['_csrf'], App::$user->token) == 0){
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
		if($model->load(App::$request->post())){
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

<?php

namespace app\controllers;

use engine\App;
use engine\base\controllers\Controller;
use app\models\ScheduleModel;
use app\models\SearchModels\ScheduleSearchModel;

/**
 * Rasp - app\controllers Контроллер
 */
/// Rasp - app\controllers Контроллер
class Rasp extends Controller
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
					'actions' => ['groups', 'create', 'update', 'view', 'delete', 'error'],
					'roles' => ['admin'],
				],
				[
					'allow' => true,
					'actions' => ['groups', 'login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'actions' => ['groups', 'index', 'view', 'error'],
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
	public function actionIndex(){
		$searchModel = new ScheduleSearchModel();
		$dataProvider = $searchModel->search(App::$request->get());
        return $this->render('view', [
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModel
		]);
	}

	/**
	 * action - Главная страница
	 */
	public function actionGroups(){
		$searchModel = new ScheduleSearchModel();
		$dataProvider = $searchModel->search(App::$request->get());
        return $this->render('index', [
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModel, 
			'sort'=>'по группам'
		]);
	}
	
	/**
	 * action - Обновить запись
	 */
	public function actionUpdate($id){
		$model = new ScheduleModel();
		if($model->load(App::$request->post())){
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
	public function actionCreate(){
		$model = new ScheduleModel();
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
		$model = new ScheduleModel();
		$model = $model->findOne($id);
        return $this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new ScheduleModel();
		$model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

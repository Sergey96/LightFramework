<?php

namespace admin\controllers;

use engine\App;
use admin\models\AssignRolesModel;
use admin\models\SearchModels\AssignSearchModel;
use engine\base\controllers\Controller;

/**
 * Assign - admin\controllers Контроллер
 */
/// Assign - admin\controllers Контроллер
class Assign extends Controller
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
					'actions' => ['index',  'login', 'error'],
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
		$searchModel = new AssignSearchModel();
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
		$model = new AssignRolesModel();
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
		$model = new AssignRolesModel();
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
		$model = new AssignRolesModel();
		$model = $model->findOne($id);
        return $this->render('view', ['model'=>$model]);
	}
	
	/**
	 * action - Удалить запись
	 */
	public function actionDelete($id){
		$model = new AssignRolesModel();
		$model = $model->findOne($id)->delete();
		$this->redirect(['index']);
	}
	
}

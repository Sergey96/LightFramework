<?php

namespace app\controllers;

use engine\base\controllers\Controller;
use app\models\ArticleModel;
use app\models\LoginFormModel;
use app\models\SearchModels\ArticleSearchModel;
use engine\WebApp;

class Home extends Controller
{
	public $Layout = 'main';
	
	public function accessRights()
	{
		return 
		[
			'access'=>[
				[
					'allow' => true,
					'actions' => ['index', 'view', 'logout', 'test'],
					'roles' => ['admin'],
				],
				[
					'allow' => true,
					'actions' => ['index','view', 'login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'actions' => ['index', 'view', 'logout'],
					'roles' => ['*'],
				]
			],
			'redirect' => [
				'controller'=>'home', 
				'view'=>'login'
			]
		];
	}

	public function action(){
		$model = new ArticleModel();
        return $this->render('index', ['model'=>$model]);
	}
	
	public function actionIndex(){
		$searchModel = new ArticleSearchModel();
		$dataProvider = $searchModel->search(WebApp::$request->get());
        return $this->render('index', [
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModel
		]);
	}

    public function actionTest(){
        return $this->asJson(["1231231"]);
    }
	
	public function actionAll(){
        return $this->render('all', ['model'=>'aaaa']);
	}
	
	public function actionUpdate($id){
		$model = new ArticleModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['index']);
		}
		else {
			$model = $model->findOne($id);
            return $this->render('update', ['model'=>$model]);
		}
	}
	
	
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
		if($model->load(WebApp::$request->post()) 
		   && $model->login()){
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
		$this->redirect(['index'], 'home');
	}
	
}

?>
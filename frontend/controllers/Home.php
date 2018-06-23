<?php

namespace frontend\controllers;

use engine\Controller\Controller;
use frontend\models\FilmsModel;
use frontend\models\ArticleModel;
use frontend\models\LoginFormModel;
use frontend\models\SearchModels\ArticleSearchModel;
use engine\WebApp;

class Home extends Controller
{
	public $Layout = 'main2';
	
	public function accessRights()
	{
		return 
		[
			'access'=>[
				[
					'allow' => true,
					'actions' => ['index', 'view', 'logout'],
					'roles' => ['admin'],
				],
				[
					'allow' => true,
					'actions' => ['index','view', 'login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'actions' => ['index', 'view'],
					'roles' => ['*'],
				]
			],
			'redirect' => [
				'controller'=>'home', 
				'view'=>'login'
			]
		];
	}
	
	public function __construct($u){
		parent::__construct($u);
	}
	
	public function action(){
		$model = new ArticleModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionIndex(){		
		$searchModel = new ArticleSearchModel();
		$dataProvider = $searchModel->search(WebApp::$request->get());
		$this->render('index', [
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModel
		]);
	}
	
	public function actionAll(){
		$this->render('all', ['model'=>'aaaa']);
	}
	
	public function actionUpdate($id){
		$model = new ArticleModel();
		if($model->load(WebApp::$request->post())){
			$model->save();
			$this->redirect(['index']);
		}
		else {
			$model = $model->findOne($id);
			$this->render('update', ['model'=>$model]);
		}
	}
	
	
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
		if($model->load(WebApp::$request->post()) 
		   && $model->login()){
			$this->redirect(['index']);
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
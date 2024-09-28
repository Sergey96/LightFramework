<?php

namespace app\controllers;

use engine\App;
use engine\base\controllers\Controller;
use app\models\ArticleModel;
use app\models\SearchModels\ArticleSearchModel;

/**
 * Articles - backend\controllers Контроллер
 */
/// Articles - backend\controllers Контроллер
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
					'actions' => ['povtias', 'error'],
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
				],
				[
					'allow' => true,
					'actions' => ['povtias', 'error', 'view'],
					'roles' => ['?'],
				]
			],
			'redirect' => [
				'controller'=>'home', 
				'view'=>'login'
			]
		];
	}
	
	/**
	 * action - Просмотреть запись
	 */
	public function actionView($id){
		$searchModel = new ArticleSearchModel();
		$dataProvider = $searchModel->search(App::$request->get());
		return $this->render('view', [
			'dataProvider'=>$dataProvider,
			'searchModel'=>$searchModel
		]);
	}
	
	
	
}

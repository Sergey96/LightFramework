<?php

namespace app\controllers;

use engine\App;
use engine\base\controllers\Controller;
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
	public function accessRights(): array
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


    public function actionIndex(): string
    {
        $searchModel = new ArticleSearchModel();
        $dataProvider = $searchModel->search(App::$request->get());
        return $this->render('index', [
            'dataProvider'=>$dataProvider,
            'searchModel'=>$searchModel
        ]);
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

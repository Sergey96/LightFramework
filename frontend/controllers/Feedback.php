<?php

namespace frontend\controllers;

use engine\WebApp;
use engine\Controller\Controller;
use frontend\models\FeedbackModel;

/**
 * Articles - backend\controllers Контроллер
 */
/// Articles - backend\controllers Контроллер
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
					'actions' => ['povtias', 'error', 'create', 'logout'],
					'roles' => ['admin'],
				],
				[
					'allow' => true,
					'actions' => ['login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'actions' => ['index', 'view', 'create', 'error', 'send'],
					'roles' => ['*'],
				],
				[
					'allow' => true,
					'actions' => ['create', 'error', 'send'],
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
	 * action - Написать письмо
	 */	
	public function actionCreate(){
		$model = new FeedbackModel();
		if($model->load(WebApp::$request->post())){
			$model->created = date("Y-m-d H:i:s");
			$model->save();
			$this->render('send');
		}
		else {
			$this->render('create', ['model'=>$model]);
		}
	}
	
}

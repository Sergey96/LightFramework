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
		$model->load(WebApp::$request->post());
		print_r($model->getErrorsLoad());
		//exit();
		if(!$model->getErrorsLoad()){
			$model->created = date("Y-m-d H:i:s");
			$model->save();
			$this->redirect(['send']);
		}
		else {
			$this->render('create', ['model'=>$model]);
		}
	}
	
	/**
	 * action - Написать письмо
	 */	
	public function actionSend(){
		$this->render('send');
	}
	
}

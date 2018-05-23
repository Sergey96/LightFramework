<?php

namespace app\controllers;

use engine\Controller\Controller;
use app\models\FilmsModel;

class Films extends Controller
{
	
	public function action(){
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionIndex(){
		$model = new FilmsModel();
		$this->render('index', ['model'=>$model]);
	}
	
	public function actionAll(){
		$this->render('all', ['model'=>'aaaa']);
	}
	
	public function actionFf(){
		$code = 1;
		$this->render('index', ['code'=>$code]);
	}
	
	
}
<?php

namespace engine\Controller;

use engine\WebApp;
use engine\base\Exceptions as Exceptions;
use engine\views\View;
/**
 * Базовый класс - Controller
 */
/// Базовый контроллер

class Error extends Controller
{

	public function __construct($URL){
		$this->ViewPath  = '../../engine/views/';
		$this->URL = "http://".$URL->getURL();
		$this->Layout = 'main';
		$this->Name = strtolower('Errors');
	}
	
	public function actionError($exception){
		$this->render('error', [
			'title' => $exception->getMessage(),
			'message'=>$exception->getMessage(),
			'code'=>$exception->getCode(),
			'objError'=>$exception->getFile(), 
			'file'=>$exception->getFile(),
			'line'=>$exception->getLine(),
			'exception'=>$exception
		]);
	}

}

?>
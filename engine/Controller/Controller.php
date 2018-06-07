<?php

namespace engine\Controller;
use engine\WebApp;
use engine\base\Exceptions as Exceptions;
use engine\views\View;
/**
 * Базовый класс - Controller
 */
/// Базовый контроллер

class Controller
{
	/// Имя контроллера
	public $Name;
	/// Действие
	public $Action;
	/// Текущий URL
	public $URL;
	/// Директория для представлений
	public $ViewPath  = '../views/';
	/// Имя шаблона views
	public $Layout;
	/// Массив параметров (breadcrumbs и т.д.)
	public $params;	
	/// Заголовок html-страницы
	public $title;

	public function accessRights(){
		return array();
	}
	
    /**
     * Конструктор класса
     *
     * @return string
     */
	public function __construct($URL){
		$this->Action = mb_strtolower($URL->Action, 'UTF-8');
		$this->URL = "http://".$URL->getURL();
		$this->Layout = 'main.php';
		$this->Name = strtolower($URL->Controller);
	}

    /**
     * Действие по умолчанию (рендерниг index-страницы)
     *
     * @return string
     */
	public function action(){
		$this->render('index');
	} 

	/**
     * Действие для controller/index (рендерниг index-страницы)
     *
     * @return string
     */
	public function actionIndex(){
		$this->render('index');
	}
	
    /**
     * Страница ошибки по умолчанию (рендерниг error-страницы)
     *
     * @return string
     */
	public function error($exception){
		
		$this->render('error', [
			'title' => $exception->getTitle(),
			'message'=>$exception->getMessage(),
			'code'=>$exception->getCode(),
			'objError'=>$exception->getElement(), 
			'file'=>$exception->getFile(),
			'line'=>$exception->getLine(),
			'exception'=>$exception
		]);
	}
	
	
    /**
     * Функция выбора действия
     *
     * @return string
     */
	public function selectAction(){
		$action = $this->getActionMethod();
		$Metods = $this->getMethods();
		$key = array_search($action, $Metods);
		if($key === false){
			throw new Exceptions\ActionNotFoundException($this->Action);
		} 
		else {
			$right = WebApp::$controller->accessRights();
			if(!WebApp::$user->can() && WebApp::$user->isRule('*')){
				throw new Exceptions\ForbiddenException($this->Action);
			}
			if(!WebApp::$user->can())
			
				$this->redirect([$right['redirect']['view']], $right['redirect']['controller']);
			
			$params = $this->getArgsForMetod($action);	
			$count = count($params);
		
			if($count>0){
				call_user_func_array(array($this, $action), $params);
			}
			else {
				$this->$action();
			}
		}
	}

    /**
     * Функция рендеринга представления
     *
     * @return string
     */
	protected function render($view, $param = array()){
		$viewObj = new View($view, $this->ViewPath, $this->Name, $this->URL);
		$layout = $this->ViewPath.'/layout/'.$this->Layout;
		ob_start();
		try{
			$content = $viewObj->render($view, $param);
			$this->title = $viewObj->getTitle();
			$this->params = $viewObj->getParams();
			require_once $layout;
		}
		catch(\Exception $e){
			$content = '';
			ob_end_clean();
			throw $e;
		}
		$contents = ob_get_clean();
		print_r($contents);
	}
	
	protected function redirect($param, $controller = false){
		if($controller===false)
			$controller = $this->Name;
		else
			$controller = $this->Name;
		$code = '200 OK';
		if(isset($param['code']))
			$code = $param['code'];
		header('HTTP/1.1 '.$code);
		header('Location: '.$this->arrayToURL($param, $controller));
	}
	
	private function arrayToURL($param, $controller){
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$controller.'/'.$param[0];
		$count = 0;
		print_r($param);
		if(count($param)>1)
			$url .= '?';
		foreach($param as $k => $p){
			$count++;
			if($count==1) continue;
			$url .= $k.'='.$p.'&';
		}
		if(count($param)>1)
			$url = substr($url, 0, strlen($url)-1);
		return str_replace("\\", "/", $url);
	}

	private function getActionMethod(){
		$action = 'action'.mb_strtoupper(mb_substr($this->Action, 0, 1), 'UTF-8');
		$action .= mb_substr($this->Action, 1, strlen($this->Action)-1, 'UTF-8');
		return $action;
	}
	
	
	private function getArgsForMetod($action){
		$class  = new \ReflectionClass($this);
		$method = $class->getMethod($action);
		$param  = $method->getParameters();
		$count = count($param);
		$args = array();
		$GET = WebApp::$request->get();
		$notFound = null;
		for($i=0; $i<$count; $i++)
		{
			$notFound = $param[$i]->name;
			foreach($GET as $name => $value)
			{
				if($param[$i]->name == $name)
				{
					$notFound = null;
					$args[] = $value;
				}
			}
			if($notFound){
				throw new Exceptions\ArgumentNotFoundException($notFound);
			}
		}
		
		return $args;
	}

    /**
     * Возвращает список методов класса
     *
     * @return array
     */
	private function getMethods(){
		return get_class_methods($this);
	}

	
	public static function startHead()
    {
		View::startHead();
    }
	
	public static function endHead()
    {
		$Asset = '\\'.WebApp::$config['namespace'].'\\assets\\AppAsset';
		View::endHead($Asset);
    }
	
	public static function endBody()
    {
		$Asset = '\\'.WebApp::$config['namespace'].'\\assets\\AppAsset';
		View::endBody($Asset);
    }
}

?>
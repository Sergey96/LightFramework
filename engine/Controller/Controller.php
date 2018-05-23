<?php

namespace engine\Controller;
use app\assets\AppAsset;
use engine\WebApp;
use engine\base\Exceptions as Exceptions;
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
	/// Поле не используется 
	public $config;
	/// Массив параметров (breadcrumbs и т.д.)
	public $params;	
	/// Заголовок html-страницы
	public $title;
	/// GET и POST - массивы
	public $request;

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
     * Страница ошибки по умолчанию (рендерниг error-страницы)
     *
     * @return string
     */
	public function error($exception){
		$this->title = $exception->getCode().": ".$exception->getMessage();
		$this->render('error', [
			'message'=>$exception->getMessage(),
			'code'=>$exception->getCode(),
			'objError'=>$exception->getElement()
		]);
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
     * Возвращает содержимое view - файла
     *
     * @return string
     */
	protected function get_include_contents($filename, $param) {
		foreach($param as $k => $v){
			${$k} = $v;
		}
		if (is_file($filename)) {
			ob_start();
			include $filename;
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}
		return false;
	}

    /**
     * Возвращает содержимое view - файла
     *
     * @return string
     */
	protected function getContentView($path, $param){
		$string = $this->get_include_contents($path, $param);
		return  $string;
	}

    /**
     * Функция рендеринга представления
     *
     * @return string
     */
	public function render($view, $param = array()){
		$layout = $this->ViewPath.'/layout/'.$this->Layout;
		$view = $this->ViewPath . $this->Name."/$view.php";
		try{
			$content = $this->getContentView($view, $param);
			require_once $layout;
		}
		catch (\Exeption $e){
			echo 'Не найден файл';
		}
	}
	
	public function redirect($param){
		header('HTTP/1.1 200 OK');
		header('Location: '.$this->arrayToURL($param));
	}
	
	private function arrayToURL($param){
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$this->Name.'/'.$param[0];
		$count = 0;
		print_r($param);
		if(count($param)>1)
			$url .= '?';
		foreach($param as $k => $p){
			$count++;
			if($count==1) continue;
			$url .= $k.'='.$p.'&';
		}
		return str_replace("\\", "/", substr($url, 0, strlen($url)-1));
	}

    /**
     * Функция выбора действия
     *
     * @return string
     */
	public function SelectAction(){
		
		$action = 'action'.mb_strtoupper(mb_substr($this->Action, 0, 1), 'UTF-8').mb_substr($this->Action, 1, strlen($this->Action)-1, 'UTF-8');
		$Metods = $this->getMethods();
		$key = array_search($action, $Metods);
		//print_r($this->Action);
		if($key === false){
			throw new Exceptions\ActionNotFoundException($this->Action);
		} 
		else {
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
	
	private function getArgsForMetod($action){
		$class  = new \ReflectionClass( $this );
		$method = $class->getMethod( $action );
		$param  = $method->getParameters();
		$count = count($param);
		$args = array();
		$GET = WebApp::$request->get();
		$notFound = null;
		for($i=0; $i<$count; $i++)
		{
			$flag = false;
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
	
	private function isIssetAllArgs($params){
		print_r($params);
		print_r(WebApp::$request->get());
		return false;
	}

    /**
     * Возвращает список методов класса
     *
     * @return array
     */
	private function getMethods(){
		return get_class_methods($this);
	}

    /**
     * Функция вывода конечной части body (js, css и т.д.)
     *
     * @return string
     */
	public function endBody()
    {
        $appAssest = new AppAsset();
        print_r($this->params);
    }
}

?>
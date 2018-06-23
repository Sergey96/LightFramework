<?php

namespace engine\views;

use engine\WebApp;
use engine\base\Exceptions as Exceptions;

class View
{

	public $ViewPath;
	public $Name;
	public $title;
	public $params;
	public $ControllerName;
	public $HomeURL;
	public $content;
	
	public function __construct($viewPath, $home){
		$this->ViewPath = $viewPath; 
		$this->HomeURL = $home;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getParams(){
		return $this->params;
	}
	
	public function getContent(){
		return $this->content;
	}
	
	public function render($view, $param = array()){
		$filepath = $this->ViewPath . "/$view.php";
		return $this->getContentView($filepath, $param);
	}	
	
	
    /**
     * Возвращает содержимое view - файла
     *
     * @return string
     */
	protected function getContentView($filename, $param) {
		foreach($param as $k => $v){
			${$k} = $v;
		}
		
		if (is_file($filename)) {
			ob_start();
			try{
				$contents ='';
				include $filename;
			}
			catch(\Exception $e){
				ob_end_clean();
				throw $e;
			}catch(\Error $e){
				ob_end_clean();
				throw $e;
			}
			$contents = ob_get_clean();
			return $contents;
		}
		else {
			throw new Exceptions\FileNotFoundException($filename);
		}
	}
	
	public static function startHead()
    {
		echo "<head>";
    }
	
	public static function endHead()
    {
		$AssetClass = '\\'.WebApp::$config['namespace'].'\\assets\\AppAsset';
		$Asset = new $AssetClass();
		echo $Asset::addStyle($Asset::$css);
		echo "</head>";
    }
	
	public static function endBody()
    {
		$AssetClass = '\\'.WebApp::$config['namespace'].'\\assets\\AppAsset';
		$Asset = new $AssetClass();
		echo $Asset::addJs($Asset::$js);
    }

}
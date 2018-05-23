<?php

namespace engine;

use engine\Components\URLManager;
use app\controllers;
use app\models;
use engine\Request\Request;
use engine\DB\DataBase;
use engine\base\Log\Logger;

class WebApp 
{
	public static $config;
	public static $request;
	public static $connection;
	public static $error;
	public static $logger;
	public static $controller;
	public static $home;
	public $URL;
	
	public function __construct($config){
		WebApp::$config = $config;
		WebApp::$request = new Request($_GET, $_POST);
		WebApp::$connection = new DataBase($config['db']);
		WebApp::$logger = new Logger();
		WebApp::$home = $this->levelUpDir($this->levelUpDir($config['home']));
		$this->run();
	}
	
	private function levelUpDir($path){
		$pos = strrpos($path, '/', -0);
		return substr($path, 0, $pos);
	}
	
	public function run(){
		$this->URL = new URLManager(WebApp::$config);
		
			$this->response();
		
	}
	
	private function response(){
		switch($this->URL->Controller){
			case "Gii": $control = "engine\\components\\Gii\\Gii"; break;
			default : $control = "app\\controllers\\".$this->URL->Controller; break;
		}
		WebApp::$controller = new $control($this->URL);
		try {
			WebApp::$controller->SelectAction();
		}
		catch(\Exception $e){
			WebApp::$controller->error($e);
		}
	}
	
}

?>
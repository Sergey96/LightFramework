<?php

namespace engine\Components;

class URLManager
{
	public $Controller;
	public $Action;
	public $config;
	public $URL;
	
	public function __construct($config){
		$this->config = $config;
		$this->URL = urldecode($_SERVER['REQUEST_URI']);
		$this->parseUrl();
	}
	
	public function parseUrl(){
		if(preg_match_all('/\//', $this->URL, $c)){
			if(strpos($this->URL, '?', 1)==(!false))
				$this->URL = substr($this->URL, 0, strpos($this->URL, '?', 1));
				
		}
		
		if($this->URL=='/'){
			$this->Controller = $this->config['controller']['default'];
		}
		else{
		
			$this->Controller = $this->getControllerName();
			$this->Action = $this->getActionName();
		}
		$this->Controller = strtoupper(substr($this->Controller, 0, 1)).substr($this->Controller, 1);
	}
	
	private function getControllerName(){
		$url = $this->URL;
		$count = preg_match_all('/\//', $url, $c);
		if($count < 2){
			$count = preg_match_all('/\/.*/', $url, $c);
			$controller = str_replace('/', '', $c[0])[0];
		}
		if($count >= 2){
			$first = strpos($url, '/', 1);
			$controller = substr($url, 1, $first-1);
		}
		return $controller;
	}
	
	public function getURL(){
		return $_SERVER['HTTP_HOST'];
	}
	
	
	private function getActionName(){
		$url = $this->URL;
		$count = preg_match_all('/\//', $url, $c);
		if($count > 1){
			$replace = '/'.$this->Controller.'/';
			$Action = str_replace($replace, '', $url);
			$first = strpos($Action, '/');
			
			if($first == 0){}
			else
				$Action = substr($Action, 0, $first);
			return $Action;
		}
		else return "";
	} 
	
}

?>
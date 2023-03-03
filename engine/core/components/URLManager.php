<?php

namespace engine\core\components;

use engine\core\exceptions as Exceptions;

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
		if($this->URL){
			if(preg_match_all('/^[\/]*[a-z]+/', $this->URL, $matches)){
				$controller = $matches[0][0];
				if(preg_match_all('/[a-z]+/', $controller, $matches)){
					$this->Controller = $this->getFirstUpper($matches[0][0]);
				}
			}
			else  {
				$this->Controller = $this->config['controller']['default'];
				$this->Action = 'index';
			}
			if(preg_match_all('/^[\/]*[a-z]+[\/]+[a-z0-9]+/', $this->URL, $matches)){
				$action = $matches[0][0];
					
				if(preg_match_all('/[a-z0-9]+$/', $action, $matches)){
					$this->Action = $matches[0][0];
				}
			}
			else  {
				$this->Action = 'index';
			}
		}
		else {
			$this->Controller = $this->config['controller']['default'];
			$this->Action = 'index';
		}
	}
	
	public function parseUrl2(){
		print_r($this->URL."\n");
		//if($this->URL)
		while($this->URL[0]=='/'){
			$this->URL = substr($this->URL, 1, strlen($this->URL));
		}
		if(!$this->URL){
			$this->Controller = $this->config['controller']['default'];
			$this->Action = 'index';
		}
		else
		{
			while($this->URL && $this->URL[0]!='/'){
				if(is_string($this->URL[0])){
					$this->Controller .= $this->URL[0];
					$this->URL = substr($this->URL, 1, strlen($this->URL));
				}
				else
					throw new  Exceptions\URLNotFoundException($_SERVER['REQUEST_URI']);
			}
			if($this->URL){
				while($this->URL[0]=='/'){
					$this->URL = substr($this->URL, 1, strlen($this->URL));
				}
				while($this->URL && $this->URL[0]!='/'){
					if(is_string($this->URL[0])){
						$this->Action .= $this->URL[0];
						$this->URL = substr($this->URL, 1, strlen($this->URL));
					}
					else
						throw new  Exceptions\URLNotFoundException($_SERVER['REQUEST_URI']);
				}
			}
			else
			{
				$this->Action = 'index';
			}
		}
		
		if(!preg_match_all('/^[a-zA-Z]*$/', $this->Controller)) 
			throw new  Exceptions\URLNotFoundException($_SERVER['REQUEST_URI']);
		if(!preg_match_all('/^[a-zA-Z]*$/', $this->Action)) 
			throw new  Exceptions\URLNotFoundException($_SERVER['REQUEST_URI']);
		$this->Controller = $this->getFirstUpper($this->Controller);
		print_r($this);
		//$this->Action = $this->getFirstUpper($this->Action);
	}
	
	private function getFirstUpper($input){
		$string = mb_strtoupper(mb_substr($input, 0, 1), 'UTF-8');
		$string .= mb_substr($input, 1, strlen($input)-1, 'UTF-8');
		return $string;
	}
	
	public function getURL(){
		return $_SERVER['HTTP_HOST'];
	}
	
}

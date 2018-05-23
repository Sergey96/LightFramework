<?php

namespace engine\Request;

class Request {
	
	private $post;
	private $get;
	
	public function __construct($_get, $_post){
		$this->post = $_post;
		$this->get = $_get;
	}
	
	public function get(){
		return $this->get;
	}
	
	public function post(){
		return $this->post;
	}
	
}

?>
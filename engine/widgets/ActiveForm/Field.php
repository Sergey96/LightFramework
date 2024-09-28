<?php

namespace engine\widgets\ActiveForm;

use engine\App;
use engine\views\View;

class Field 
{
	private $name;
	private $id;
	private $class;
	private $value;
	private $type;
	private $label;
	private $params;
	
	private $viewObj;
	// Папка представлений
	public static $ViewPath = '../../engine/widgets/ActiveForm/views/';
	
	public function __construct($name, $label, $value, $params = array()){
		$this->name = $name;
		$this->label = $label;
		$this->value = $value;
		$this->params = $params;
		$this->viewObj = new View(self::$ViewPath, App::$controller->URL);
	}
	
	public function textarea($params = array()){
		$input = $this->viewObj->render('textarea',[
				'name'=>$this->name,
				'value'=>$this->value,
				'params'=>$params,
			]);
		return $this->control('control','block', $input, $params);
	}
	
	public function passwordInput($params = array()){
		$input = $this->input('password', $params);
		return $this->control('control','block', $input, $params);
	}
	
	public function textInput($params = array()){
		$input = $this->input('text', $params);
		return $this->control('control','block', $input, $params);
	}
	
	public function hiddenInput($params = array()){
		$input = $this->input('hidden', $params);
		return $this->control('control','none', $input, $params);
	}
	
	private function input($type, $params){
		return $this->viewObj->render('input',[
				'name'=>$this->name,
				'class'=>$this->class,
				'value'=>$this->value,
				'params'=>$params,
				'type'=>$type, 
			]);
	}
	
	private function control($view,  $display, $input, $params){
		return $this->viewObj->render($view, [
				'display'=>$display,
				'name'=>$this->name,
				'label'=>$this->label,
				'input'=>$input,
				'params'=>$params
			]);
	}
	
	public function __toString(){
		return $this->textInput();
	}
	
}


?>
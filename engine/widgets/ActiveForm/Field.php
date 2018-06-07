<?php

namespace engine\widgets\ActiveForm;

use engine\WebApp;

class Field 
{
	public $htmlCode;
	private $name;
	private $id;
	private $class;
	private $value;
	private $type;
	private $label;
	private $params;
	
	private $control = '
		<div class="control-group  col-xs-12" style="display:{display}">
            <label class="control-label   col-xs-4" for="ModelName">{label}</label>
            <div class="controls col-xs-6">
				{input}
			</div>
		</div>
	';
	
	public $template = [
		'input'=>'<input name="{name}" class="form-control" placeholder="{name}" id="{name}" class="{class}" value="{value}" type="{type}">
		',
		'textarea'=>'
			<textarea name="{name}" class="form-control" placeholder="{name}" rows="{rows}" cols="{cols}" id="{name}" class="{class}">{value}</textarea>
		',
		];
	
	public function __construct($name, $label, $value, $params = array()){
		$this->name = $name;
		$this->label = $label;
		$this->value = $value;
		$this->params = $params;
	}
	
	private function replaceStandartAttrib(){
		$this->htmlCode = str_replace('{name}', $this->name, $this->htmlCode);
		$this->htmlCode = str_replace('{value}', $this->value, $this->htmlCode);
		$this->control = str_replace('{label}', $this->label, $this->control);
		$this->replaceParam('id', $this->params, '');
		$this->replaceParam('class', $this->params, '');
	}
	
	private function replaceInput(){
		$this->htmlCode = $this->template['input'];
		$this->replaceStandartAttrib();
	}
	
	private function replaceArea(){
		$this->htmlCode = $this->template['textarea'];
		$this->replaceStandartAttrib();
	}
	
	public function replaceParam($name, $params, $default){
		$find = '{'.$name.'}';
		if(isset($params[$name]))
			$this->htmlCode = str_replace($find, $params[$name], $this->htmlCode);
		else 
			$this->htmlCode = str_replace($find, $default, $this->htmlCode);
	}
	
	public function textInput($params = array()){
		$this->replaceInput();
		$this->htmlCode = str_replace('{type}', 'text', $this->htmlCode);
		return str_replace('{input}', $this->htmlCode, $this->control);
	}
	
	public function hiddenInput($params = array()){
		$this->replaceInput();
		$this->htmlCode = str_replace('{type}', 'hidden', $this->htmlCode);
		$this->control = str_replace('{display}', 'none', $this->control);
		return str_replace('{input}', $this->htmlCode, $this->control);
	}
	
	public function passwordInput($params = array()){
		$this->replaceInput();
		$this->htmlCode = str_replace('{type}', 'password', $this->htmlCode);
		return str_replace('{input}', $this->htmlCode, $this->control);
	}
	
	public function textarea($params = array()){
		$this->replaceArea();
		$this->replaceParam('rows', $params, 4);
		$this->replaceParam('cols', $params, 40);
		//$this->replaceParam('col', $params, 100);
		return str_replace('{input}', $this->htmlCode, $this->control);
	}
	
	public function __toString(){
		return $this->htmlCode;
	}
	
}


?>
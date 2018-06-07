<?php

namespace engine\widgets\ActiveForm;

use engine\WebApp;
use engine\widgets\ActiveForm\Field;
use engine\base\Exceptions as Exceptions;

/**
 * Виджет ActiveForm 
 * Генерирует html-код формы
 */
/// Виджет ActiveForm 
class ActiveForm 
{
	private static $URL;
	public $form;
	private static $tplBegin = "
	<form name='{name}' action='{action}' method='{method}'>
	";
	private static $begin;
	private static $params;
	public $template = "
	<div id='' class='{class}'>
		<div class='input-label'>{label}</div>
		<div class='input-field'>{field}</div>
	</div>
	";
	
	private static function replaceParam($name, $params, $default){
		$find = '{'.$name.'}';
		if(isset($params[$name]))
			ActiveForm::$begin = str_replace($find, $params[$name], ActiveForm::$begin);
		else 
			ActiveForm::$begin = str_replace($find, $default, ActiveForm::$begin);
	}
	
	public static function begin($params = array()){
		ActiveForm::$begin = ActiveForm::$tplBegin;
		ActiveForm::$URL = $_SERVER['REQUEST_URI'];
		ActiveForm::replaceParam('name', $params, WebApp::$controller->Action);
		ActiveForm::replaceParam('action', $params, ActiveForm::$URL);
		ActiveForm::replaceParam('method', $params, 'post');
		ActiveForm::$params = $params;

		echo ActiveForm::$begin;
		return new ActiveForm();
	}
	
	public static function end(){
		echo "</form>\n";
	}
	
	public function field($model, $fieldName, $param = array()){
		if(property_exists(get_class($model), $fieldName)){
			$field = new Field($fieldName, $model::$attributeLabels[$fieldName][0], $model->$fieldName, $param);
			return $field;
		}
		else throw new Exceptions\PropertyNotFoundException($fieldName, __METHOD__);
	}
	
}


?>
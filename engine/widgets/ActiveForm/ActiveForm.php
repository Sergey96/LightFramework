<?php

namespace engine\widgets\ActiveForm;

use engine\WebApp;
use engine\core\exceptions as Exceptions;
use engine\views\View;

/**
 * Виджет ActiveForm 
 * Генерирует html-код формы
 */
/// Виджет ActiveForm 
class ActiveForm 
{
	// Каталог представлений
	public static $ViewPath = '../../engine/widgets/ActiveForm/views/';
	
	public static $name;
	public static $action;
	public static $method;
	
	public static function begin($params = array()){
		self::$name = self::getParam('name', $params, WebApp::$controller->Action);
		self::$action = self::getParam('action', $params, $_SERVER['REQUEST_URI']);
		self::$method = self::getParam('method', $params, 'post');
	
		$viewObj = new View(self::$ViewPath, WebApp::$controller->URL);
		$form = $viewObj->render('form', [
					'name'=>self::$name,
					'action'=>self::$action,
					'method'=>self::$method,
					'_csrf'=>WebApp::$user->token,
				]);
			
		echo $form;
		return new ActiveForm();
	}
	
	public static function end(){
		echo "</form>\n";
	}
	
	private static function getParam($name, $params, $default){
		if(isset($params[$name]))
			return $params[$name];
		else 
			return $default;
	}
	
	public function field($model, $fieldName, $param = array()){
		if(property_exists(get_class($model), $fieldName)){
			$field = new Field($fieldName, $model::$attributeLabels[$fieldName][0], $model->$fieldName, $param);
			return $field;
		}
		else throw new Exceptions\PropertyNotFoundException($fieldName, __METHOD__);
	}
	
}

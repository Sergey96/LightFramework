<?php

namespace app\models;

use engine\App;

/**
 * Модель - LoginFormModel модель формы авторизацииы
 */
class LoginFormModel extends \common\User\UsersModel
{
	/**
	 * Логин
	 */
	public $login;
	
	/**
	 * Пароль от 6 символов
	 */
	public $password;
	
	/**
	 * Текст ошибки авторизации
	 */
	public $error;
	
	/**
	 * Правила валидации данных
	 */
	public static $attributeLabels =
	[
		'login' => ['LOGIN', 'text', 'required'],
		'password' => ['PASSWORD', 'text', 'required'],
	];
	
	/**
	 * Авторизоваться
	 */
	public function login(){
		return App::$user->login($this);
	}
}


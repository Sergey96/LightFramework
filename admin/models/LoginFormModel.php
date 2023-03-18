<?php

namespace admin\models;

use engine\WebApp;
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
		return WebApp::$user->login($this);
	}
}


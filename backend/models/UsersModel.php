<?php

namespace backend\models;

use engine\WebApp;
	
/**
 * Модель - UsersModel
 */
class UsersModel extends \common\User\UsersModel
{

	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'name' => ['NAME', 'text', 'required'],
		'password' => ['PASSWORD', 'text', 'null'],
		'token' => ['TOKEN', 'text', 'null'],
		'created' => ['CREATED', 'datetime', 'required'],
		'avatar' => ['AVATAR', 'text', 'required']
	];

}


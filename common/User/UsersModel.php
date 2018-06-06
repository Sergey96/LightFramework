<?php

namespace common\User;

use engine\base\Exceptions as Exceptions;
/**
 * Модель таблицы Users; Данные пользователя
 *
 * @property int $id
 * @property text $name
 * @property text $password
 * @property datetime $created
 * @property text $avatar

 */
class UsersModel extends \engine\DB\ActiveRecord
{
	/**
     * @inherited
     *
     */
	public $Table = 'users';
	public $id;
	public $name;
	public $password;
	public $token;
	public $created;
	public $avatar;
	
	/**
     * @inherited
     *
     */
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'name' => ['NAME', 'text', 'required'],
		'password' => ['PASSWORD', 'text', 'required'],
		'token' => ['TOKEN', 'text', 'null'],
		'created' => ['CREATED', 'datetime', 'required'],
		'avatar' => ['AVATAR', 'text', 'required']
	];
	
	/**
     * @inherited
     *
     */
	/*public function save($validate = true){
		if($this->validate($validate)){
			$Query = $this->generateQuery();
			$stmt = $this->prepare($Query);
			$stmt->execute($this->getDataAsArray($this->isNew));
			$errors = $stmt->errorInfo();
			if($errors[1])
				throw new Exceptions\DatabaseException($errors[2]);
		}
		else throw new Exceptions\ErrorFieldTypeException($this->fieldsErrorType);
	}*/
	
}


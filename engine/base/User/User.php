<?php

namespace engine\base\User;

use engine\WebApp;
use engine\base\Exceptions as Exceptions;
use engine\Components\AccessManager;
use common\User\UsersModel;

class User extends \engine\db\ActiveRecord
{
	public $id;
	public $name;
	public $role;
	public $created;
	public $avatar;
	
	public static $attributeLabels =
	[
		'id' => ['ID', 'int', 'autoincrement'],
		'name' => ['NAME', 'text', 'required'],
		'role' => ['ROLE', 'text', 'null'],
		'created' => ['CREATED', 'datetime', 'required'],
		'avatar' => ['AVATAR', 'text', 'required']
	];
	
	private $session;
	
	public function __get($property){
		if(property_exists(get_class($this), $property)){
			return $property;
		}
		else 
			throw new Exceptions\PropertyNotFoundException($property);
	}
	
	public function __construct(){
		$this->session = $_SESSION;
		$model = new UsersModel();
		$login = $this->getSessionValue('user');
		if($login){
			$model = $model->getByField('name', $this->session['user']);
			if($this->compareString($model->token, $this->session['token'])){
				$this->load($model->getDataAsArray(false));
			}
		}
	}
	
	private function getSessionValue($name){
		if(isset($this->session[$name]))
			return $this->session[$name];
		else return false;
	}
	
	public function can(){
		$right = WebApp::$controller->accessRights();
		if($this->id){
			$roles = AccessManager::findRoles($this->id);
			$roles[] = "*";
		} else
			$roles = ['?'];
			
		$access = false;
		$this->roles = $roles;
		if($right){
			foreach($right['access'] as $rule){
				if($rule['allow']==true){
					$result = array_intersect ($rule['roles'], $roles);
					if(count($result)>0){
						$method = array_search(WebApp::$controller->Action, $rule['actions']);
						//var_dump($method);
						if($method===false)
							$access = false;
						else {
							$access = true;
							break;
						}
					}
				}
			}
			return $access;
		} else return true;
	}
	
	public function isRule($rule){
		//var_dump($this->roles);
		$method = array_search($rule, $this->roles);
		if($method===false) 
			return false;
		else return true;
	}
	
	public function login($user){
		$class = get_parent_class($user);
		$model = new $class();
		$model = $model->getByField('name', $user->login);
		var_dump($model->password);
		var_dump($user->password);
		var_dump(md5((string)$user->password));
		//exit();
		if(AccessManager::decryptPassword($user->password, $model->password)){

			$this->load($model->getDataAsArray(false));
			$this->auth();
			$model->token = $_SESSION['token'];
			$model->setNotNew();
			$model->save();
			//print_r($model);
			//exit();
			return true;
		}
		$user->error = 'Неверный логин или пароль';
		return false;
	}
	
	public function logout(){
		session_destroy();
	}
	
	private function auth(){
		$_SESSION['user'] = $this->name;
		$_SESSION['token'] = md5($this->name . $this->id . time());
		print_r($_SESSION);
	}
	
	public function checkPassword($authPassword, $tablePassword){
		return AccessManager::decryptPassword($authPassword, $tablePassword);
	}
	
	public function compareString($authPassword, $tablePassword){
		return strcmp($authPassword, $tablePassword) === 0;
	}

}
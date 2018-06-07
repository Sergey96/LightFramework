<?php

namespace engine\Components;

use engine\WebApp;
use \common\User\AccessRolesModel;
use \common\User\AssignRolesModel;

class AccessManager
{
	
	public static function encryptPassword($password){
		return password_hash($password, PASSWORD_BCRYPT);
	}
	
	public static function decryptPassword($password, $hash){
		return password_verify($password, $hash);
	}
	
	public static function findRoles($id){
		$model = new AccessRolesModel();
		$assign_model = new AssignRolesModel();
		$result = WebApp::$connection->executeQuery('
			SELECT * 
			FROM 
				`assign_roles`, `access_roles` 
			WHERE 
				`assign_roles`.`id_user` = '.$id.' AND 
				`assign_roles`.`id_roles` = `access_roles`.`id`'
			);
		$answer = $result->fetchAll(\PDO::FETCH_ASSOC);
		$roles = array();
		foreach($answer as $v)
			$roles[] = $v['name'];
			
		return $roles;
	}
	
}

?>
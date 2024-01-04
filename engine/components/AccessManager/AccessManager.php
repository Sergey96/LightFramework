<?php

namespace engine\components\AccessManager;

class AccessManager
{
	public static function encryptPassword($password){
		return password_hash($password, PASSWORD_BCRYPT);
	}
	
	public static function decryptPassword($password, $hash){
		return password_verify($password, $hash);
	}
	
	public static function findRoles($id){
		return AccessManagerRepository::findRoles($id);
	}
}

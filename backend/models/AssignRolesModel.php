<?php

namespace backend\models;

use \common\User\UserModel;

class AssignRolesModel extends \common\User\AssignRolesModel
{
	
	public function getUsers()
    {
        return $this->OneToMany('\common\User\UserModel', ['id_user' => 'id']);
    }
	
}


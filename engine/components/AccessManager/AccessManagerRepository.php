<?php

namespace engine\components\AccessManager;

use engine\App;

class AccessManagerRepository
{
    public static function findRoles($id){
        $sql = '
			SELECT 
			    * 
			FROM 
				assign_roles, access_roles 
			WHERE 
				assign_roles.id_user = '.$id.' AND 
				assign_roles.id_role = access_roles.id
        ';

        $result = App::$connection->executeQuery($sql);
        $answer = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach($answer as $value)
        {
            $roles[] = $value['name'];
        }

        return $roles ?? [];
    }

}
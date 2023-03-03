<?php

namespace engine\Components;

use engine\WebApp;

class AccessManagerRepository
{
    public static function findRoles($id){
        $sql = '
			SELECT 
			    * 
			FROM 
				`assign_roles`, `access_roles` 
			WHERE 
				`assign_roles`.`id_user` = '.$id.' AND 
				`assign_roles`.`id_roles` = `access_roles`.`id`
        ';

        $result = WebApp::$connection->executeQuery($sql);
        $answer = $result->fetchAll(\PDO::FETCH_ASSOC);

        foreach($answer as $value)
        {
            $roles[] = $value['name'];
        }

        return $roles ?? [];
    }

}
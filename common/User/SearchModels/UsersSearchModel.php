<?php

namespace common\User\SearchModels;

use engine\core\exceptions\DataBaseException;
use engine\db\DataProvider\DataProvider;

/// AccessRolesModel - SearchModel

class UsersSearchModel extends \common\User\UsersModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())
            ->from($this->Table)
            ->all();
	}
	
	public function findOne($id){
		
	}

    /**
     * @throws DataBaseException
     */
    public function findName($name): bool|array|null
    {
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())
            ->from($this->Table)
            ->where("name = '$name'")
            ->One()
            ->exe($this);
	}
}


<?php

namespace common\User\SearchModels;

use engine\db\DataProvider\DataProvider;

/// AccessRolesModel - SearchModel

class UsersSearchModel extends \common\User\UsersModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
	
	public function findOne($id){
		
	}
	
	public function findName($name){
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->where("name = '$name'")->One()->exe($this);
	}
}


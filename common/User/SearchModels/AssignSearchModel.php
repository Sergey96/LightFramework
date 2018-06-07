<?php

namespace common\User\SearchModels;

use engine\db\DataProvider\DataProvider;

/// AccessRolesModel - SearchModel

class AssignSearchModel extends \common\User\AssignRolesModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


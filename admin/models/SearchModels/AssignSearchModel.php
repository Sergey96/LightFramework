<?php

namespace admin\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// AssignRolesModel - SearchModel

class AssignSearchModel extends \admin\models\AssignRolesModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


<?php

namespace backend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// AssignRolesModel - SearchModel

class AssignSearchModel extends \backend\models\AssignRolesModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


<?php

namespace backend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// AccessRolesModel - SearchModel

class AccessSearchModel extends \backend\models\AccessRolesModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


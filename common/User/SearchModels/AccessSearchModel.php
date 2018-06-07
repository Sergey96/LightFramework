<?php

namespace common\User\SearchModels;

use engine\db\DataProvider\DataProvider;

/// AccessRolesModel - SearchModel

class AccessSearchModel extends \common\User\AccessRolesModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


<?php

namespace backend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// UsersModel - SearchModel

class UsersSearchModel extends \backend\models\UsersModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


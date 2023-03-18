<?php

namespace admin\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// UsersModel - SearchModel

class UsersSearchModel extends \admin\models\UsersModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


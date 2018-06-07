<?php

namespace backend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// TTModel - SearchModel

class TTSearchModel extends \backend\models\TTModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


<?php

namespace ###NAMESPACE###;

use engine\db\DataProvider\DataProvider;

/// ###CLASS_NAME### - SearchModel

class ###SEARCH_CLASS_NAME### extends \backend\models\###CLASS_NAME###
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


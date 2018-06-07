<?php

namespace backend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// ScheduleModel - SearchModel

class ScheduleSearchModel extends \backend\models\ScheduleModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


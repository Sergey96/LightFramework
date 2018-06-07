<?php

namespace frontend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// ScheduleModel - SearchModel

class ScheduleSearchModel extends \frontend\models\ScheduleModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


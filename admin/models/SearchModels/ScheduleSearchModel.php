<?php

namespace admin\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// ScheduleModel - SearchModel

class ScheduleSearchModel extends \admin\models\ScheduleModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


<?php

namespace app\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// ScheduleModel - SearchModel

class ScheduleSearchModel extends \app\models\ScheduleModel
{
	public function search($get){	
		if(isset($get['id'])) $id = $get['id'];
		$provider = new DataProvider();
		$provider = $provider->select($this->getFields())->from($this->Table);
		
		if(isset($get['id']))
			$provider = $provider->where('id_teacher = '.$get['id']);
		
		return $provider->all();
	}
}


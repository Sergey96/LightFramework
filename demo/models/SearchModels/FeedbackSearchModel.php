<?php

namespace backend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// FeedbackModel - SearchModel

class FeedbackSearchModel extends \backend\models\FeedbackModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


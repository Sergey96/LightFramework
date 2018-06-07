<?php

namespace frontend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// ArticleModel - SearchModel

class ArticleSearchModel extends \frontend\models\ArticleModel
{
	public function search($param){	
		$dataProvider = new DataProvider();
		$dataProvider = $dataProvider->select($this->getFields())->from($this->Table)->all();
		
		if(isset($param['id']))
			return $dataProvider->where('id='.$param['id'])->One();
		
		return $dataProvider->all();
	}
}


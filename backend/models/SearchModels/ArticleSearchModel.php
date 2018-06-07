<?php

namespace backend\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// ArticleModel - SearchModel

class ArticleSearchModel extends \backend\models\ArticleModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


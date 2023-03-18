<?php

namespace admin\models\SearchModels;

use engine\db\DataProvider\DataProvider;

/// ArticleModel - SearchModel

class ArticleSearchModel extends \admin\models\ArticleModel
{
	public function search(){	
		$dataProvider = new DataProvider();
		return $dataProvider->select($this->getFields())->from($this->Table)->all();
	}
}


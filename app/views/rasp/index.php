<?php

use engine\widgets\GridView\GridView;

$this->title = 'Статьи';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "Статьи";
?>
<div class="articles-view">
	<?php
	$list = $dataProvider->exe($searchModel);
	print_r($list);
//
//	foreach($list as $article){
//		print_r($article->content);
//		$this->title = $article->title;
//	}
	?>	
</div>

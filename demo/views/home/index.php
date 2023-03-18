<?php

use engine\widgets\GridView\GridView;

$this->title = 'Добро пожаловать на сайт кафедры ПОВТиАС';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "О Кафедре";
?>
<div class="articles-view">
	<?php
	$list = $dataProvider->exe($searchModel);
	foreach($list as $article){
		echo $this->render('newbox', ['article'=>$article]);
	}
	?>	
</div>

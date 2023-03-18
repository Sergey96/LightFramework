<?php

use engine\widgets\NEWS\NEWS;

$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = ['label'=>'Статьи', 'url'=>$this->HomeURL.'/article'];
$this->params['breadcrumbs'][] = 'О кафедре';
?>
<div class="articles-view">
	
	<?php
	$NEWS = new NEWS([
		'dataProvider'=>$dataProvider,
		'searchModel'=>$searchModel,
		'template'=>'standart'
	]);
	$this->title = $NEWS->title;
	?>	
</div>

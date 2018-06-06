<?php

use engine\widgets\GridView\GridView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "О Кафедре";
?>
<div class="articles-view">
	<?php $list = $model->getAll();
	foreach($list as $article){
		echo $this->render('newbox', ['article'=>$article]);
	}
	?>	
</div>

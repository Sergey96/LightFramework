<?php

use engine\widgets\GridView\GridView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "Статьи";
?>
<div class="articles-view">
	<?= $model->content ?>	
</div>

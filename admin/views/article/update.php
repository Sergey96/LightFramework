<?php

use engine\widgets\GridView\GridView;

$this->title = 'Добавить '.$model->Table;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Изменить статью</h4>
	<?= $this->render('_form', ['model'=>$model]); ?>		
</div>

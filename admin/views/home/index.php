<?php

use engine\widgets\GridView\GridView;

$this->title = 'Главная страница';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4><?= $model->Table ?></h4>
	<a class='btn btn-success' href='/access/create'>Создать</a>
</div>

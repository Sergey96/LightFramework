<?php

use engine\widgets\GridView\GridView;

$this->title = 'Просмотр';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Показать все</h4>
	<a class='btn btn-success' href='/assign/create'>Создать</a>
	<?php
		$GRID = new GridView([
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'fields'=>[
				'id:int',
				'id_user:int',
				'id_role:int',
			]
		]);
	?>
</div>

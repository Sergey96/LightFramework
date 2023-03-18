<?php

use engine\widgets\GridView\GridView;

$this->title = 'Просмотр';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Показать все</h4>
	<a class='btn btn-success' href='/schedule/create'>Создать</a>
	<?php
		$GRID = new GridView([
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'fields'=>[
				'id:int',
				'id_group:int',
				'number_work:int',
				'type_week:text',
				'number_day:int',
				'sub_group:int',
				'type_work:text',
				'title_work:text',
				'room:text',
				'id_teacher:int',
			]
		]);
	?>
</div>

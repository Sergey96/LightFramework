<?php

use engine\widgets\GridView\GridView;

$this->title = 'Расписание '.$sort;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "Расписание";
?>
<div class="articles-view">
	<?php
		$GRID = new GridView([
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'fields'=>[
				'id:text',
				'id_group:text',
				'number_work:text',
				'type_week:text',
				'number_day:text',
				'sub_group:text',
				'type_work:text',
				'title_work:text',
				'room:text',
				'id_teacher:text'
			]
		]);
	
	?>	
</div>

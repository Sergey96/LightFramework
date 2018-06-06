<?php

use engine\widgets\GridView\GridView;

$this->title = $model->Table;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4><?= $model->Table ?></h4>
	<a class='btn btn-success' href='/rasp/create'>Создать</a>
	<?php
		$GRID = new GridView([
			'model' => $model,
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

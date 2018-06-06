<?php

use engine\widgets\GridView\GridView;

$this->title = $model->Table;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <h4><?= $model->Table ?></h4>
	<a class='btn btn-success' href='/users/create'>Создать</a>
	<?php
		$GRID = new GridView([
			'model' => $model,
			'fields'=>[
				'id:int',
				'name:text',
				'password:text',
				'created:datetime',
				'avatar:text',
			]
		]);
	?>
</div>

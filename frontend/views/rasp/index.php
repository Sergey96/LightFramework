<?php

use engine\widgets\GridView\GridView;

$this->title = 'Расписание по группам';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
	<a class='btn btn-success' href='/rasp/create'>Создать</a>
	<pre>
	<?php 
	
		print_r($model);
	?>
	</pre>
</div>

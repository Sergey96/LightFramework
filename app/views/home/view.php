<?php

use engine\widgets\GridView\GridView;

$this->title = 'Редактировать фильмы';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Изменить <?= $model->Table ?></h4>
		<table>
			<?php
				foreach($model->attributeLabels as $name => $properties){
			?>
					<tr><td><?= $name ?></td><td><?= $model->$name ?></td></tr>
			<?php
				}
			?>
		</table>
</div>

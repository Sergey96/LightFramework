<?php

use engine\widgets\GridView\GridView;

$this->title = 'Редактировать фильмы';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->URL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Изменить <?= $model->Table ?></h4>
	
	<form name='<?= $model->Table ?>' action='/home/update?id=<?= $model->id ?>' method='post'>
		<table>
		<?php
			foreach($model->attributeLabels as $name => $properties){
		?>
				<tr><td><?= $name ?></td><td><input type='text' name='<?= $name ?>' value='<?= $model->$name ?>'></td></tr>
		<?php
			}
		?>
		</table>
		<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	</form>
</div>

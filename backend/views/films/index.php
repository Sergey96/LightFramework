<?php

use engine\widgets\GridView\GridView;

$this->title = 'Все фильмы';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Основные работы опубликованы на ЯД по ссылке ниже13</h4>
	<!--<div id="tools">
			<div class="tools-element t-e-first">
				<button class='btn-standart btn-aqva' name='addString'>Добавить строку</button>
				<div class="tools-line"></div>
			</div>
			<div class="tools-element">
				<button class='btn-standart btn-gray' name='addString'>Экспорт</button>
			</div>
			<div class="tools-element">
				<button class='btn-standart btn-gray' name='addString'>Импорт</button>
			</div>
			<div class="tools-element t-e-last">
				<label>Языковая версия
					<select name="language">
						<option value='RU'>Русский</option>
					</select>
				<label>
			</div>
		</div>
		-->
	<?php
		$GRID = new GridView([
			'model' => $model,
			'fields'=>[
				'id:int',
				'title:text',
				'add_date:date',
				'rating:int',
				'status:text',
				'description:text',
				'url:text',
				'director:text',
				'company:text'
			]
		]);
	?>
</div>

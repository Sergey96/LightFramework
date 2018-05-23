<?php

use engine\widgets\GridView;

$this->title = 'Все фильмы';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->URL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Основные работы опубликованы на ЯД по ссылке ниже1</h4>
	<div id="tools">
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
	<?php
		$GRID = new GridView([
			'model' => $model,
			'fields'=>[
				'title:text',
				'url:text',
				'label:text'
			]
		]);
		
		print_r($GRID);
	?>
	<table>
		<tr>
			<td>Методички</td><td><a href="#">http://disk.yandex.ru/files</a></td>
		</tr>
		<tr>
			<td>Лабы</td><td><a href="#">http://disk.yandex.ru/labs</a></td>
		</tr>
		<tr>
			<td>Вопросы/Ответы к экзаменам</td><td><a href="#">http://disk.yandex.ru/ekz</a></td>
		</tr>
		<tr>
			<td>Практики</td><td><a href="#">http://disk.yandex.ru/pract</a></td>
		</tr>
		<tr>
			<td>Учебная литература</td><td><a href="#">http://disk.yandex.ru/libs</a></td>
		</tr>
	</table>
</div>

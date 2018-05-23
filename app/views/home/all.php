<?php

//use yii\helpers\Html;

$this->title = 'Все фильмы';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->URL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Основные работы опубликованы на ЯД по ссылке ниже</h4>
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

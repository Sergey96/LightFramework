<?php
	$this->title = "Генератор Моделей";
?>
<div class="gii-models">
    <h4>Генератор Моделей</h4>
	<form name='' action='/gii/generate?type=models' method='post'>
		<p>Имя Таблицы *</p>
		<input type='text' name='tableName' value='films'>
		<p>Имя Класса Модели *</p>
		<input type='text' name='className' value='FilmsModel'>
		<p>Пространство Имен *</p>
		<input type='text' name='nameSpace' value='app\models'> 
		<p>Имя Класса Родителя *</p>
		<input type='text' name='parentClass' value='\engine\base\models\ActiveRecord'>
		<p>Префикс таблиц </p>
		<input type='text' name='tablePrefix' value=''> 
		<p>Генерировать Label из Комментариев БД </p>
		<input type='checkbox' name='isLabel' checked=checked /> 
		<p>Шаблон Кода </p>
		<input type='text' name='templateName' value='/templates/ModelTemplate'> 
		<input type='submit' name='send' value='Генерировать'> 
	</form>
</div>
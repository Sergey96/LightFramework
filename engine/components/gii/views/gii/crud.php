<?php
	$this->title = "Генератор Моделей";
?>
<div class="gii-models">
    <h4>Генератор CRUD</h4>
	<form class="form-horizontal" name='' action='/gii/generate?type=crud' method='post'>
          <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="ModelName">Имя Класса Модели *</label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="ModelName" name="ModelName" placeholder="ModelName" value='Model'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="SearchModelName">Имя Search Модели *</label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="SearchModelName" name="SearchModelName" placeholder="SearchModelName" value='SearchModel'>
            </div>
          </div>
          <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="ModelNamespace">Пространство имен Модели *</label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="ModelNamespace" name="ModelNamespace" placeholder="ModelNamespace" value='backend\models'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="ControllerName">Имя Контроллера*</label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="ControllerName" name="ControllerName" placeholder="ControllerName" value='Site'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="ControllerNamespace">namespace Контроллера*</label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="ControllerNamespace" name="ControllerNamespace" placeholder="nameSpace" value='backend\controllers'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="ViewPath">Каталог views* (совпадает с именем контроллера)</label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="ViewPath" name="ViewPath" placeholder="ViewPath" value='backend/views'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="ControllerTpl">Шаблон Контроллера </label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="ControllerTpl" name="ControllerTpl" placeholder="ControllerTpl" value='/templates/ControllerTemplate'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="SearchModelTpl">Шаблон SearchModel </label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="SearchModelTpl" name="SearchModelTpl" placeholder="SearchModelTpl" value='/templates/SearchModelTemplate'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="IndexTpl">Шаблон Index файла </label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="IndexTpl" name="IndexTpl" placeholder="IndexTpl" value='/templates/ViewsIndexTemplate'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="CreateTpl">Шаблон Create </label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="CreateTpl" name="CreateTpl" placeholder="CreateTpl" value='/templates/ViewsCreateTemplate'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="UpdateTpl">Шаблон Update </label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="UpdateTpl" name="UpdateTpl" placeholder="UpdateTpl" value='/templates/ViewsUpdateTemplate'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="ViewTpl">Шаблон View </label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="ViewTpl" name="ViewTpl" placeholder="ViewTpl" value='/templates/ViewsViewTemplate'>
            </div>
          </div>
		  <div class="control-group  col-xs-12">
            <label class="control-label   col-xs-4" for="FormTpl">Шаблон _form </label>
            <div class="controls col-xs-6">
              <input class="form-control" type="text" id="FormTpl" name="FormTpl" placeholder="FormTpl" value='/templates/Views_formTemplate'>
            </div>
          </div>
          <div class="control-group  col-xs-12">
            <div class="controls col-xs-6">
				<input type='submit' class='btn btn-primary' name='send' value='Генерировать'> 
            </div>
          </div>
	</form>
</div>
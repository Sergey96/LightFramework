<?php

use engine\widgets\ActiveForm\ActiveForm;

$this->title = 'Изменить пароль '.$model->Table;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="Users-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'id')->hiddenInput() ?>
		<?= $form->field($model, 'password')->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

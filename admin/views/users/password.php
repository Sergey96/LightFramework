<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

$this->title = 'Сменить пароль';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="Users-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'password')->textInput() ?>
		<?= $form->field($model, 'password')->textInput() ?>
		<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

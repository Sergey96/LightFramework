<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Users-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'name')->textarea() ?>
		<?= $form->field($model, 'password')->textarea() ?>
		<?= $form->field($model, 'created')->textInput() ?>
		<?= $form->field($model, 'avatar')->textarea() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

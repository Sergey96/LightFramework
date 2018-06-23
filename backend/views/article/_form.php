<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Article-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'id')->hiddenInput() ?>
		<?= $form->field($model, 'title')->textInput() ?>
		<?= $form->field($model, 'created')->textInput() ?>
		<?= $form->field($model, 'description')->textarea() ?>
		<?= $form->field($model, 'content')->textarea() ?>
		<?= $form->field($model, 'owner')->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Feedback-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'id')->textInput() ?>
		<?= $form->field($model, 'sender')->textarea() ?>
		<?= $form->field($model, 'sender_email')->textarea() ?>
		<?= $form->field($model, 'theme')->textarea() ?>
		<?= $form->field($model, 'content')->textarea() ?>
		<?= $form->field($model, 'created')->textInput() ?>
		<?= $form->field($model, 'readed')->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

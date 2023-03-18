<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Rasp-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'id_group')->textInput() ?>
		<?= $form->field($model, 'number_work')->textInput() ?>
		<?= $form->field($model, 'type_week')->textarea() ?>
		<?= $form->field($model, 'number_day')->textInput() ?>
		<?= $form->field($model, 'sub_group')->textInput() ?>
		<?= $form->field($model, 'type_work')->textarea() ?>
		<?= $form->field($model, 'title_work')->textarea() ?>
		<?= $form->field($model, 'room')->textarea() ?>
		<?= $form->field($model, 'id_teacher')->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

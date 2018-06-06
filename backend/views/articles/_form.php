<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Articles-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'title')->textarea() ?>
		<?= $form->field($model, 'description')->textarea() ?>
		<?= $form->field($model, 'content')->textarea() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

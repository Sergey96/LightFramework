<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="TT-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'id')->textInput() ?>
		<?= $form->field($model, 'dd')->textInput() ?>
		<?= $form->field($model, 'ss')->textInput() ?>
		<?= $form->field($model, 'aa')->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

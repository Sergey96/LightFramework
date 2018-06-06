<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Access-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?php // $form->field($model, 'id')->textInput() ?>
		<?= $form->field($model, 'name')->textarea() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

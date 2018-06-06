<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Submenu-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'name')->textarea() ?>
		<?= $form->field($model, 'link')->textarea() ?>
		<?= $form->field($model, 'id_section')->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

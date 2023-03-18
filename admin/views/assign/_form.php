<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="Assign-_form">
	
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'id')->textInput() ?>
		<?= $form->field($model, 'id_user')->textInput() ?>
		<?= $form->field($model, 'id_roles')->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

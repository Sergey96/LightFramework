<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="###CONTROLLER_NAME###-_form">
	
	<?php $form = ActiveForm::begin(); ?>
###FIELDS###
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

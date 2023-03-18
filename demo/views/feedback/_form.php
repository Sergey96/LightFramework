<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="site-about">
	
	<?php $form = ActiveForm::begin(); ?>
			<?= $form->field($model, 'sender')->textInput() ?>
			<?= $form->field($model, 'sender_email')->textInput() ?>
			<?= $form->field($model, 'theme')->textInput() ?>
			<?= $form->field($model, 'content')->textarea() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>
	
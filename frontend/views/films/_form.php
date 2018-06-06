<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="site-about">
	
	<?php $form = ActiveForm::begin(); ?>
			<?= $form->field($model, 'id', ['class'=>'text-field', 'id'=>'global'])->textInput() ?>
			<input type='submit' class='btn btn-primary' name='save' value='Сохранить'>
	<?php ActiveForm::end(); ?>
</div>

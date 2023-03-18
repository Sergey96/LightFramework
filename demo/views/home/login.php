<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-login">
    <h4>Авторизация</h4>
    <pre class='alert-danger'><h5><?php if($model->error) echo "Внимание: ".$model->error; ?></h5></pre>
	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'login')->textInput() ?>
		<?= $form->field($model, 'password')->textInput() ?>
		<input type='submit' class='btn btn-primary' name='save' value='Войти'>
	<?php ActiveForm::end(); ?>		
</div>

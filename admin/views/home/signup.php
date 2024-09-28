<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

$this->title = 'Ре17012020
гистрация';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-login">
    <h4>Авторизация</h4>
    <h5><?php if($model->error) echo "Внимание: ".$model->error; ?></h5>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'login', ['class'=>'col-xs-3'])->textInput() ?>
    <?= $form->field($model, 'password', ['class'=>'col-xs-3'])->textInput() ?>
    <input type='submit' class='btn btn-primary' name='save' value='Войти'>
    <?php ActiveForm::end(); ?>
</div>

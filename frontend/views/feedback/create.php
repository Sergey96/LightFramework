<?php

use engine\widgets\GridView\GridView;

$this->title = 'Отправить письмо';
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Добавить <?= $model->Table ?></h4>
	<?= $this->render('_form', ['model'=>$model]); ?>		
</div>

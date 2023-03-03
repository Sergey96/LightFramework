<?php

use engine\widgets\GridView\GridView;

$this->title = 'Добавить '.$model->Table;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h4>Добавить <?= $model->Table ?></h4>
	<?php if($error = $model->getErrorsLoad()) echo "<code class='alert-danger'><pre>$error</pre></code>"; ?>
	<?= $this->render('_form', ['model'=>$model]); ?>		
</div>

<?php
use engine\App;

$this->title = $title;

$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "Ошибка";

?>
<div class="site-error">

    <div class="alert alert-danger">
        <b><?= $message?>: "<?= $objError ?>"</b>
		<p><?= $file ?> в строке <b><?= $line ?></b></p>
    </div>
	<div>
		<pre><?php print_r($exception); ?></pre>
	</div>

</div>

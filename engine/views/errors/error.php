<?php

use engine\WebApp; 
use engine\base\Helpers\html;

$this->title = html::toUTF8($title);
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "Страница ошибки";

?>
<div class="site-error">

    <div class="alert alert-danger">
        <b><?= html::toUTF8($message) ?>: "<?= $objError ?>"</b>
		<p><?= $file ?> в строке <b><?= $line ?></b></p>
    </div>
	<div>
		<pre><?php print_r($exception); ?></pre>
	</div>

</div>

<?php

use engine\core\helpers\html;

$this->title = html::toUTF8($title ?? '');
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "Страница ошибки";

?>
<div class="site-error">

    <div class="alert alert-danger">
        <b><?= html::toUTF8($message ?? '') ?>: "<?= $objError ?? '' ?>"</b>
		<p><?= $file ?? '' ?> в строке <b><?= $line ?? '' ?></b></p>
    </div>
	<div>
		<pre><?php print_r($exception); ?></pre>
	</div>

</div>
<script src=" https://cdn.jsdelivr.net/npm/axios@1.3.4/dist/axios.min.js "></script>
<script>
    const res = axios.get("http://vk-parser.com/home/sdfs")
    res.then((data) => {
        console.log(data)
    })

</script>



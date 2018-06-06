<?php
use engine\WebApp; 

$this->title = $title;

?>
<div class="site-error">

    <div class="alert alert-danger">
        <b><?= $message?>: "<?= $objError ?>"</b>
		<p><?= $file ?> в строке <b><?= $line ?></b></p>
    </div>

</div>

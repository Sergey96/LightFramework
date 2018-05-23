<?php
use engine\WebApp; 

$back_img = base64_encode(file_get_contents(__DIR__."../404.png"));

?>
<style>
	body {
		background: url(data:image/png;base64, <?= $back_img ?>"
	}
</style>
<div class="site-error">

    <h1><?= $this->title ?></h1>

    <div class="alert alert-danger">
        <?= $message ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>

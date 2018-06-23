<?php
	$rows = ''; if(isset($params['rows'])) $rows = 'rows="'.$params['rows'].'"';
	$cols = ''; if(isset($params['cols'])) $cols = 'cols="'.$params['cols'].'"';
?>
<textarea name="<?= $name ?>" class="form-control" placeholder="<?= $name ?>" id="<?= $name ?>" <?= $rows ?> <?= $cols ?>><?= $value ?></textarea>		
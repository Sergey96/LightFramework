<?php

use yii\helpers\Html;
use engine\widgets\ActiveForm\ActiveForm;

?>
<div class="newbox">
	
	<div class='box-title'>
		<p><?= $article->title ?></p>
	</div>
	<div class='box-content'>
		<div class='box-description'>
			<p><?= $article->description ?></p>
		</div>
		<div class='box-detail'>
			<a href="/article/view?id=<?= $article->id ?>">Подробнее...</a>
		</div>
		<div class='box-created'>
			Создан: <?= $article->created ?>
		</div>
		<div class='box-owner'>
			Владелец: <?= $article->owner ?>
		</div>
	</div>
</div>

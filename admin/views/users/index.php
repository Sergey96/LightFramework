<?php

use engine\widgets\GridView\GridView;

$this->title = 'Просмотр';
$this->params['breadcrumbs'][] = ['label' => 'Главная', 'url' => $this->HomeURL];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about col-md-12">
    <div class="d-flex flex-row justify-content-between align-items-center">
        <div class="col-md-3">
            <h4>Пользователи</h4>
        </div>
        <div class="col-md-3">
            <a class='btn btn-success' href='/users/create'>Создать</a>
        </div>
    </div>

    <?php
    $GRID = new GridView([
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'fields' => [
            'id:int',
            'name:text',
            'password:varchar(255)',
            'token:text',
            'created:datetime',
            'avatar:text',
        ]
    ]);
    ?>
</div>

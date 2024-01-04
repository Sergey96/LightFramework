<?php

use engine\widgets\GridView\GridView;

$sort = $sort ?? 'asc';
$this->title = 'Расписание '.$sort;
$this->params['breadcrumbs'][] = ['label'=>'Главная', 'url'=>$this->HomeURL];
$this->params['breadcrumbs'][] = "Расписание";
?>
<div class="site-about">
    <h4><a href="">Изменить <?= $model->Table ?></a></h4>
    <table>
        <?php
        foreach($model::$attributeLabels as $name => $properties){
            ?>
            <tr><td><?= $name ?></td><td><?= $model->$name ?></td></tr>
            <?php
        }
        ?>
    </table>
</div>

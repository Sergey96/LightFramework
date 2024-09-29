<?php

use engine\App;
use engine\widgets\Breadcrumbs;

$this->title = $title;
$this->params = $params;

?>

<!DOCTYPE html>
<html>
<?php $this->startHead() ?>
<title><?= $this->title ?></title>

<?php $this->endHead() ?>
<body>
<div id="page">
    <div id="sidebar">
        <a class="sidebar_title" href="/">LIGHT FRAMEWORK</a>
        <ul class='sidebar-menu'>
            <li class='sidebar-header'></li>
            <li>
                <a href='#'><span>Генератор кода</span></a>
                <ul class='sidebar-submenu'>
                    <li><a href='/gii/crud'>Генератор CRUD</a></li>
                    <li><a href='/gii/models'>Генератор моделей</a></li>
                </ul>
            </li>
            <li>
                <a href='#'><span>Права Доступа</span></a>
                <ul class='sidebar-submenu'>
                    <li><a href='/users/'>Пользователи</a></li>
                    <li><a href='/access/'>Роли доступа</a></li>
                    <li><a href='/assign'>Связь Ролей и пользователей</a></li>
                </ul>
            </li>
            <li>
                <a href='#'><span>Наполнение</span></a>
                <ul class='sidebar-submenu'>
                    <li><a href='/article/'>Статьи</a></li>
                    <li><a href='/feedback/'>Обратная связь</a></li>
                    <li><a href='/schedule/'>Расписание</a></li>
                </ul>
            </li>
        </ul>

    </div>
    <div id="wrapper">
        <div id="wrapper-title">
            <div id="breadcrumbs">
                <div class='col-xs-9'>
                    <?php Breadcrumbs::View($this->params['breadcrumbs']); ?>
                </div>
                <?php
                if (!App::$user->name) { ?>
                    <div class='login-box col-xs-3'><a href='/home/login'>Войти</a></div>
                    <?php
                } else { ?>
                    <div class='logout-box col-xs-3'>
                        <a href='/home/logout'>Выход: </a><span class='logout-user'><?= App::$user->name ?></span>
                    </div>
                <?php } ?>
            </div>
            <div id="content-title">
                <div id="content-title-string">
                    <p><?= $this->title ?></p>
                </div>
                <div id="content-title-img">
                    <img src=''>
                </div>
            </div>
            <div id="reminder">
                <img src=''>
            </div>
        </div>
        <div id="content">
            <div id="data">
                <!-- TABLE -->
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>

</body>
<script type='text/javascript'>
    $.sidebarMenu($('.sidebar-menu'))
    var HH = 71;

    function hideBox(el) {
        if ($("#filters-body").hasClass("v")) {
            $("#filters-body").height(1)
            $("#filters-body").removeClass("v")
            el.style.transform = "rotate(0deg)";
        } else {
            $("#filters-body").addClass("v")
            $("#filters-body").height(HH)
            el.style.transform = "rotate(-90deg)";
        }

    }
</script>
</html>
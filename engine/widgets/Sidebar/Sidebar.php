<?php

namespace engine\widgets\Sidebar;

use engine\App;
use engine\widgets\Sidebar\models\SidebarSearchModel;
use engine\views\View;

/**
 * Виджет - Сайдбар
 * Вывод бокового меню
 */
/// Виджет - Сайдбар
class Sidebar
{
	// Папка представлений
	public static $ViewPath = '../../engine/widgets/Sidebar/views/';
	
	public static function View(){
		$model = new SidebarSearchModel();
		$menus = $model->search();
		$viewObj = new View(self::$ViewPath, App::$controller->URL);
		return $viewObj->render('ul', ['menus'=>$menus]);
	}

}

?>
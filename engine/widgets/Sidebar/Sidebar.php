<?php

namespace engine\widgets\Sidebar;

use engine\WebApp;
use engine\widgets\Sidebar\models\SectionModel;
use engine\widgets\Sidebar\models\SubMenuModel;

/**
 * Виджет - хлебные крошки
 * отображение иерархии разделов сайта
 */
/// Виджет - хлебные крошки
class Sidebar
{
	/**
	 * Шаблон для элемента - ссылки
	 */
	public static $template = "
		<a href=''>ГЛАВНАЯ</a>
	<ul class='sidebar-menu'>
		<li class='sidebar-header'></li>
		{LI}
	</ul>
	";
	
	public static $templateLI = "
		<li>
			<a href='#'><span>{section}</span></a>
			<ul class='sidebar-submenu'>
				{submenu}
			</ul>
		</li>
	";
	
	public static $templateSubmenu = "
				<li><a href='{href}'>{title}</a></li>";
	
	public static function View(){
		$result = WebApp::$connection->executeQuery("
			SELECT 
				`ss`.`id` as `id`,
				`ss`.`name` as `section`,
				`sm`.`name` as `submenu`,
				`sm`.`link` as `link` 
			FROM 
				`sidebar_submenu` as `sm`, 
				`sidebar_section` as `ss` 
			WHERE 
			   `sm`.`id_section` = `ss`.`id`
			");
		$rows = $result->fetchAll(\PDO::FETCH_ASSOC);
		$menus = array();
		foreach($rows as $k=>$r){
			$menus[$r['id']][] = $r;
		}
		$li = '';
		$LI = '';
		foreach($menus as $id => $menu){
			$li = '';
			foreach($menu as $value){
				$li .= str_replace('{href}', $value['link'], self::$templateSubmenu);
				$li = str_replace('{title}', $value['submenu'], $li);
			}
			$LI .=  str_replace('{section}', $menu[0]['section'], self::$templateLI);
			$LI =  str_replace('{submenu}', $li, $LI);
		}
		return str_replace('{LI}', $LI, self::$template);
	}

}

?>
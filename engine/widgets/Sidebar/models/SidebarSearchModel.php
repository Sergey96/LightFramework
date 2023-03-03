<?php

namespace engine\widgets\Sidebar\models;

use engine\base\models\ActiveRecord;
use engine\WebApp;

/**
 * Модель - SidebarSearchModel Разделы сайдбара
 */
class SidebarSearchModel extends ActiveRecord
{
	public function search(){
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
		return $menus;
	}
}


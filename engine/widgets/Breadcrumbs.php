<?php

namespace engine\widgets;

/**
 * Виджет - хлебные крошки
 * отображение иерархии разделов сайта
 */
/// Виджет - хлебные крошки
class BreadCrumbs
{
	/**
	 * Шаблон для элемента - ссылки
	 */
	public $template = "
	<li><a href='{url}'>{label}</a></li> ";
	
	/**
	 * Шаблон для последнего элемента, обычный текст
	 */
	public $templateNotLink = "
	<li>{label}</li>";
	
	/**
	 * Метка, текст ссылки
	 */
	public $label;
	
	/**
	 * URL - адрес
	 */
	public $url;

	/**
	 * Вывести хлебные крошки
	 */
	public static function View($params){
		$bread = new BreadCrumbs();
		$html = '<ul>';
		
		foreach($params as $k => $v){
			if(is_array($v)){
				$u = str_replace("{url}", $v['url'], $bread->template);
				
				$l = str_replace("{label}", self::getLabel($v['label']), $u);
			}
			else {
				$l = str_replace("{label}",  self::getLabel($v), $bread->templateNotLink);
			}
			$html .= $l;
		}
		$html .= '</ul>';
		print_r($html);
	//	exit();
	}
	
	private static function getLabel($label){
		return $label;
	}

}

?>
<?php

namespace engine\widgets;

class BreadCrumbs
{
	public $template = "<li><a href='{url}'>{label}</a></li> > ";
	public $templateNotLink = "<li>{label}</li>";
	public $label;
	public $url;

	public static function printBreadCrumbs($params){
		$bread = new BreadCrumbs();
		$html = '<ul>';
		
		foreach($params as $k => $v){
			if(is_array($v)){
				$u = str_replace("{url}", $v['url'], $bread->template);
				$l = str_replace("{label}", $v['label'], $u);
			}
			else {
				$l = str_replace("{label}", $v, $bread->templateNotLink);
			}
			$html .= $l;
		}
		$html .= '</ul>';
		print_r($html);
	}

}

?>
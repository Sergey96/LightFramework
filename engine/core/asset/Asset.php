<?php

namespace engine\core\asset;

class Asset
{
	protected static $StyleTemplate = '
		<link rel="stylesheet" href="{href}">';
	
	protected static $JSTemplate = '
		<script src="{src}"></script>';

	public static function addStyle($css){
		$CSS = '';
		foreach($css as $href){
			$CSS .= str_replace('{href}', $href, Asset::$StyleTemplate);
		}
		return $CSS;
	}

	public static function addJS($js){
		$JS = '';
		foreach($js as $href){
			$JS .= str_replace('{src}', $href, Asset::$JSTemplate);
		}
		return $JS;
	}

}

?>
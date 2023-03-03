<?php

namespace engine\core\helpers;

use engine\WebApp;

class html
{
	public static function p($text){
		
	}

	public static function toUTF8($text){
		if(mb_check_encoding($text, 'utf8'))
			return $text;
		if(mb_check_encoding($text, 'windows-1251'))
			return iconv('windows-1251', 'utf-8', $text);
	}
	
}
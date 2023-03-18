<?php

namespace app
{ 

    /**
     * Autoloader - подгрузка всех классов проекта
     */
	/// подгрузка всех классов проекта
	class Autoloader
	{
		/**
		 * DEBUG-режим
		 */
		const debug = 1;
		
		
		/**
		 * Конструктор - пустой
		 */
		public function __construct(){}

		/**
		 * Точка входа - запуск автозагрузки
		 * - сканируются все директории текущего уровня и вниз
		 */
		public static function autoload($file)
		{
			$file = str_replace('\\', '/', $file);
			$path = __DIR__ . '/';
			$filepath = __DIR__ . '/' . $file . '.php';
			if (file_exists($filepath))
				{
				if(Autoloader::debug) Autoloader::StPutFile(('подключили ' .$filepath));
					require_once($filepath);
			}
			else
			{ 
				$flag = true;
				if(Autoloader::debug) Autoloader::StPutFile(('начинаем рекурсивный поиск'));
					Autoloader::recursive_autoload($file, $path, $flag);
			}
		}

		
		/**
		 * Рекурсивный просмотр каталогов, подключение классов во вложенных папках
		 */
		public static function recursive_autoload($file, $path, &$flag)
		{
			if(!is_dir($path)) return;
			if (FALSE !== ($handle = opendir($path)) && $flag) {
				while (FAlSE !== ($dir = readdir($handle)) && $flag) {
					if (strpos($dir, '.') === FALSE) {
						$path2 = $path . '/' . $dir;
						$filepath = $path2 . '/' . $file . '.php';
						if (Autoloader::debug) {
                            Autoloader::StPutFile(('ищем файл <b>' . $file . '</b> in ' . $filepath));
                        }
						if (file_exists($filepath)) {
							if (Autoloader::debug) Autoloader::StPutFile(('подключили ' . $filepath));
								$flag = FALSE;
								print_r('ищем файл <b>' . $file . '</b> in ' . $filepath);
							require_once($filepath);
							break;
						} else {
//						    print_r("<p>Файл не найден: <b>" . $file . '</b> in ' . $filepath . "</p>");
                        }
						Autoloader::recursive_autoload($file, $path2, $flag);
					}
				}
				closedir($handle);
			}
		}
  
		/**
		 * Логируем что нашли
		 */
		private static function StPutFile($data)
		{
		    $path = $_SERVER['DOCUMENT_ROOT'];
			$dir = self::levelUpDir($path)  . '/runtime/log.html';
			$file = fopen($dir, 'a');

			flock($file, LOCK_EX);
			fwrite($file, ('¦' .$data .'=>' .date('d.m.Y H:i:s') .'<br/>¦<br/>' .PHP_EOL));
			flock($file, LOCK_UN);
			fclose ($file);
		}

        private static function levelUpDir($path){
            $pos = strrpos($path, '/', -0);
            return substr($path, 0, $pos);
        }
    
	}

	/**
     * Запуск автозагрузки классов
     */
	\spl_autoload_register('app\Autoloader::autoload');
}
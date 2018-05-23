<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class FileNotFoundException extends Exception
{
	/**
	 * Не найденный адрес
	 * @var File
	 */
	private $file;

	/**
	 * @param File $file 
	 */
	public function __construct(File $file)
	{
		Exception::__construct('Не найден Файл '.$file->oneLine);
		$this->file = $file;
	}
	/**
	 * @return File
	 */
	public function getFile()
	{
		return $this->file;
	}
}
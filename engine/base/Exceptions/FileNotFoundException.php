<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class FileNotFoundException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Файл не найден');
		$this->element = $element;
		$this->code = 404;
		$this->title = $this->message;
	}
	
}
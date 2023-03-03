<?php

namespace engine\core\exceptions;
/**
 * Файл не найден
 */
class FileNotFoundException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Файл не найден "'.$element.'"');
		$this->element = $element;
		$this->code = 404;
		$this->title = $this->message;
	}
	
}
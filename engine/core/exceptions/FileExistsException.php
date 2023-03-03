<?php

namespace engine\core\exceptions;
/**
 * Файл уже существует
 */
class FileExistsException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Файл Уже Существует');
		$this->element = $element;
		$this->code = '';
		$this->title = $this->message;
	}

}
<?php

namespace engine\base\Exceptions;
/**
 * Файл уже существует
 */
class FileExistsException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Файл Уже Существует');
		$this->element = $element;
		$this->code = '';
		$this->title = $this->message;
	}

}
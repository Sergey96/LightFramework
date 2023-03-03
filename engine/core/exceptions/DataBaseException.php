<?php

namespace engine\core\exceptions;
/**
 * Исключение при работе с БД
 */
class DataBaseException extends \engine\core\exceptions\BaseException
{

	public function __construct($element, $code = 404)
	{
		parent::__construct('Исключение БД');
		$this->element = $element;
		$this->code = $code;
		$this->title = 'Исключение БД';
	}
	
}
<?php

namespace engine\base\Exceptions;
/**
 * Исключение при работе с БД
 */
class DataBaseException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element, $code = 404)
	{
		parent::__construct('Исключение БД');
		$this->element = $element;
		$this->code = $code;
		$this->title = 'Исключение БД';
	}
	
}
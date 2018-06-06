<?php

namespace engine\base\Exceptions;
/**
 * Не найден параметр
 */
class ParameterNotFoundException extends \engine\base\Exceptions\BaseException
{
	
	public function __construct($element)
	{
		parent::__construct('Параметр не найден');
		$this->element = $element;
		$this->code = 500;
		$this->title = $this->message;
	}
	
}
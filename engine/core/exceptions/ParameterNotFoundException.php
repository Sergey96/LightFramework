<?php

namespace engine\core\exceptions;
/**
 * Не найден параметр
 */
class ParameterNotFoundException extends \engine\core\exceptions\BaseException
{
	
	public function __construct($element)
	{
		parent::__construct('Параметр не найден');
		$this->element = $element;
		$this->code = 500;
		$this->title = $this->message;
	}
	
}
<?php

namespace engine\core\exceptions;
/**
 * Аргумент не найден
 */
class ArgumentNotFoundException extends \engine\core\exceptions\BaseException
{
	public function __construct($element)
	{
		parent::__construct('Не найден аргумент');
		$this->element = $element;
		$this->code = 500;
		$this->title = $this->message;
	}
}
<?php

namespace engine\base\Exceptions;
/**
 * Аргумент не найден
 */
class ArgumentNotFoundException extends \engine\base\Exceptions\BaseException
{
	public function __construct($element)
	{
		parent::__construct('Не найден аргумент');
		$this->element = $element;
		$this->code = 500;
		$this->title = $this->message;
	}
}
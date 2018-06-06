<?php

namespace engine\base\Exceptions;
/**
 * Не найдено свойство объекта
 */
class PropertyNotFoundException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Поле не найдено');
		$this->element = $element;
		$this->code = 500;
		$this->title = $this->message;
	}
	
}
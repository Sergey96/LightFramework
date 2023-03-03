<?php

namespace engine\core\exceptions;
/**
 * Не найдено свойство объекта
 */
class PropertyNotFoundException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Поле не найдено');
		$this->element = $element;
		$this->code = 500;
		$this->title = $this->message;
	}
	
}
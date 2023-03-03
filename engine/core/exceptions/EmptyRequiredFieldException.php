<?php

namespace engine\core\exceptions;
/**
 * Запрашиваемое поле не содержит данных
 */
class EmptyRequiredFieldException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Запрашиваемое поле не содержит данных "'.$element.'"');
		$this->element = $element;
		$this->code = '';
		$this->title = $this->message;
	}
	
}
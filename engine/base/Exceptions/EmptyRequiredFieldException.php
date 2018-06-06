<?php

namespace engine\base\Exceptions;
/**
 * Запрашиваемое поле не содержит данных
 */
class EmptyRequiredFieldException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Запрашиваемое поле не содержит данных');
		$this->element = $element;
		$this->code = '';
		$this->title = $this->message;
	}
	
}
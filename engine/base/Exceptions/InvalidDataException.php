<?php

namespace engine\base\Exceptions;
/**
 * Данные имеют неверный формат
 */
class InvalidDataException extends \engine\base\Exceptions\BaseException
{
	public function __construct($element)
	{
		parent::__construct('Данные имеют неверный формат "'.$element.'"');
		$this->element = $element;
		$this->code = '';
		$this->title = 'Данные имеют неверный формат';
	}
}
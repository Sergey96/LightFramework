<?php

namespace engine\core\exceptions;
/**
 * Данные имеют неверный формат
 */
class InvalidDataException extends \engine\core\exceptions\BaseException
{
	public function __construct($element)
	{
		parent::__construct('Данные имеют неверный формат "'.$element.'"');
		$this->element = $element;
		$this->code = '';
		$this->title = 'Данные имеют неверный формат';
	}
}
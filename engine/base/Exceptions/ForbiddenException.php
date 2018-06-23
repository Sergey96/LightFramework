<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class ForbiddenException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Forbidden 403');
		$this->element = $element;
		$this->code = 403;
		$this->title = 'Forbidden 403';
	}
}
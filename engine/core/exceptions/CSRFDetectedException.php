<?php

namespace engine\core\exceptions;
/**
 * Файл не найден
 */
class CSRFDetectedException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Обнаружена CSRF-атака');
		$this->element = $element;
		$this->code = 404;
		$this->title = $this->message;
	}
}
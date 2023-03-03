<?php

namespace engine\core\exceptions;
/**
 * Запрашиваемый URL не найден
 */
class URLNotFoundException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Страница не найдена "'.strtolower($element).'"');
		$this->element = $element;
		$this->code = 404;
		$this->title = $this->message;
	}
	
}
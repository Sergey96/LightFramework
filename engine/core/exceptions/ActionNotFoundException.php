<?php

namespace engine\core\exceptions;
/**
 * Файл не найден
 */
class ActionNotFoundException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Страница  не найдена "'.$element.'"');
		$this->element = $element;
		$this->code = 404;
		$this->title = 'Страница  не найдена';
	}
}
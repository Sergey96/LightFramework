<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class ActionNotFoundException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Страница  не найдена');
		$this->element = $element;
		$this->code = 404;
		$this->title = 'Страница  не найдена';
	}
}
<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class ModelNotFoundException extends \engine\base\Exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Запрошенный "id" не существует. ID');
		$this->element = $element;
		$this->code = 404;
		$this->title = 'Запись Не найдена';
	}
}
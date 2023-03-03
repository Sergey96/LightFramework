<?php

namespace engine\core\exceptions;
/**
 * Файл не найден
 */
class ModelNotFoundException extends \engine\core\exceptions\BaseException
{

	public function __construct($element)
	{
		parent::__construct('Запрошенный "id" не существует. ID');
		$this->element = $element;
		$this->code = 404;
		$this->title = 'Запись Не найдена';
	}
}
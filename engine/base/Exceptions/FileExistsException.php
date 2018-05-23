<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class FileExistsException extends \Exception
{
	/**
	 * Не найденный файл
	 * @var Element
	 */
	public $element;

	/**
	 * @param Element $element 
	 */
	public function __construct($element)
	{
		\Exception::__construct('Файл Уже Существует');
		$this->element = $element;
		$this->code = '';
	}
	/**
	 * @return Element
	 *
	 */
	public function getElement()
	{
		return $this->element;
	}
}
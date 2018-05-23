<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class ArgumentNotFoundException extends \Exception
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
		\Exception::__construct('Не найден аргумент');
		$this->element = $element;
		$this->code = 404;
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
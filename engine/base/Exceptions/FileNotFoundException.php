<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class FileNotFoundException extends \Exception
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
		\Exception::__construct('Файл не найден');
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
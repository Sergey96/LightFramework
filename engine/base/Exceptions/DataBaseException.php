<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class DataBaseException extends \Exception
{
	/**
	 * Не найденный адрес
	 * @var Element
	 */
	public $element;

	/**
	 * @param Element $element 
	 */
	public function __construct($element, $code = 404)
	{
		\Exception::__construct('Ошибка БД');
		$this->element = $element;
		$this->code = $code;
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
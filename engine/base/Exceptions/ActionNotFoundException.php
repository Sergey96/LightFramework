<?php

namespace engine\base\Exceptions;
/**
 * Файл не найден
 */
class ActionNotFoundException extends \Exception
{
	/**
	 * Не найденный адрес
	 * @var Element
	 */
	public $element;

	/**
	 * @param Element $element 
	 */
	public function __construct($element)
	{
		\Exception::__construct('Страница  не найдена');
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
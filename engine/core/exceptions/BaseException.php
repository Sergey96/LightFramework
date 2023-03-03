<?php

namespace engine\core\exceptions;
/**
 * Базовый Класс Исключения
 */
class BaseException extends \Exception
{
	/**
	 * Не найденный файл
	 * @var Element
	 */
	protected $element;
	protected $title;

	/**
	 * @param Element $element 
	 */
	public function __construct($message)
	{
		\Exception::__construct($message);
	}
	/**
	 * @return Element
	 *
	 */
	public function getElement()
	{
		//print_r($this);
		return $this->element;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
}
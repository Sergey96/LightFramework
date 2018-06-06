<?php

namespace engine\base\Exceptions;
/**
 * Неожиданное Исключение
 */
class Exception extends \engine\base\Exceptions\BaseException
{

	public function __construct($errno, $errstr, $errfile, $errline)
	{
		parent::__construct("$errstr Line:$errline");
		$this->element = $errfile;
		$this->code = $errno;
		$this->file = $errfile;
		$this->OutLine = $errline;
		$this->title = $this->message;
	}
	
}
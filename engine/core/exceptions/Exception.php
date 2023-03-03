<?php

namespace engine\core\exceptions;
/**
 * Неожиданное Исключение
 */
class Exception extends \engine\core\exceptions\BaseException
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
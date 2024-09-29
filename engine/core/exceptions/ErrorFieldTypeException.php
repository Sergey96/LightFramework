<?php

namespace engine\core\exceptions;
/**
 * Поле имеет некорректный тип данных
 */
class ErrorFieldTypeException extends BaseException
{

    public function __construct($element)
    {
        parent::__construct('Поле имеет некорректный тип данных "'.$element.'"');
        $this->element = $element;
        $this->code = '';
        $this->title = $this->message;
    }

}
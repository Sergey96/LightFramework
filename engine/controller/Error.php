<?php

namespace engine\Controller;

use engine\base\controllers\Controller;

/**
 * ErrorController
 */
/// Error контроллер

class Error extends Controller
{

    public function __construct($URL, $isAjax = false)
    {
        $this->ViewPath = '/engine/views/';
        $this->URL = "http://" . $URL->getURL();
        $this->Layout = 'main';
        $this->Name = strtolower('Errors');
        $this->isAjax = $isAjax;
    }

    public function actionError($exception)
    {
        if ($this->isAjax)
        {
            $result = [
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ];
            print_r($result);
            return $this->asJson(['error' => $result]);
        }

        return $this->render('error', [
            'title' => $exception->getMessage(),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'objError' => $exception->getFile(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'exception' => $exception,
            'isAjax' => $this->isAjax,
        ]);
    }

}
<?php

namespace engine\Controller;

use engine\base\controllers\Controller;
use engine\core\components\URLManager;
use engine\App;

/**
 * ErrorController
 */
/// Error контроллер

class Error extends Controller
{
    public function __construct(URLManager $URL, $isAjax = false)
    {
        $this->ViewPath = '/engine/views/';
        $this->URL = $URL->getProtocol() . "://" . $URL->getURL();
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

            return $this->asJson(['error' => $result]);
        }

        $error = [
            'title' => App::isDebug() ? $exception->getMessage() : 'Ошибка сервера',
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'objError' => $exception->getFile(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'exception' => $exception,
            'isAjax' => $this->isAjax,
        ];

        return $this->render('error', $error);
    }

}
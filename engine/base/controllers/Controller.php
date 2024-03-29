<?php

namespace engine\base\controllers;

use engine\core\components\URLManager;
use engine\WebApp;
use engine\core\exceptions as Exceptions;
use engine\views\View;

/**
 * Базовый класс - Controller
 */
/// Базовый контроллер

class Controller
{
    /// Имя контроллера
    public $Name;
    /// Действие
    public $Action;
    /// Текущий URL
    public $URL;
    /// Директория для представлений
    public $ViewPath;
    /// Имя шаблона views
    public $Layout;
    /// Массив параметров (breadcrumbs и т.д.)
    public $params;
    /// Заголовок html-страницы
    public $title;
    /// Формирование ответов по умолчанию в json
    public $isAjax = false;

    public const DEFAULT_LAYOUT = 'main';

    public function accessRights()
    {
        return array();
    }

    /**
     * Конструктор класса
     *
     * @param $URL
     * @param $isAjax
     */
    public function __construct(URLManager $URL, $isAjax)
    {
        $this->Name = $URL->getController();
        $this->Action = $URL->getAction();

        $this->Layout = $this::DEFAULT_LAYOUT;

        $this->URL = $URL->getProtocol() . "://" . $URL->getURL();

        $this->ViewPath = $this->getViewPath();
//        print_r($this->ViewPath);
        $this->isAjax = $isAjax;
    }

    private function getViewPath()
    {
        return '/'. WebApp::$config['namespace'] . '/views/';
    }

    /**
     * Действие по умолчанию (рендерниг index-страницы)
     *
     * @return string
     */
    public function action()
    {
        return $this->render('index');
    }

    /**
     * Действие для controller/index (рендерниг index-страницы)
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Страница ошибки по умолчанию (рендерниг error-страницы)
     *
     * @return string
     */
    public function error($exception)
    {
        return $this->render('error', [
            'title' => $exception->getMessage(),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'objError' => $exception->getFile(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'exception' => $exception
        ]);
    }


    /**
     * Функция выбора действия
     *
     * @return string
     * @throws Exceptions\ActionNotFoundException
     * @throws Exceptions\ArgumentNotFoundException
     * @throws Exceptions\ForbiddenException
     */
    public function execAction()
    {
        $this->checkAccess();
        $action = $this->getActionMethod();
        $methods = $this->getMethods();

        $isExist = array_search($action, $methods);
        if ($isExist === false) {
            throw new Exceptions\ActionNotFoundException($this->Action);
        } else {

            $params = $this->getArgsForMethod($action);
            $count = count($params);

            if ($count > 0) {
                return call_user_func_array(array($this, $action), $params);
            } else {
                return $this->$action();
            }
        }
    }

    private function checkAccess()
    {
        $right = WebApp::$controller->accessRights();
        $isCan = WebApp::$user->can();
        if (!$isCan && WebApp::$user->isRule('*')) {
            throw new Exceptions\ForbiddenException($this->Action);
        }
        if (!$isCan) {
            $this->redirect([$right['redirect']['view']], $right['redirect']['controller']);
        }
    }

    /**
     * Функция рендеринга представления
     *
     * @param $view
     * @param array $param
     * @return string
     */
    protected function render(string $view, $param = [])
    {
        $isEngineView = $this->isEngineView($param);
        $viewObj = new View($this->getViewFile($isEngineView), $this->URL);
        $layoutObj = new View($this->getLayoutFile($isEngineView), $this->URL);

        $content = $viewObj->render($view, $param);

        return $layoutObj->render($this->Layout, [
            'content' => $content,
            'title' => $viewObj->getTitle(),
            'params' => $viewObj->getParams()
        ]);
    }

    private function isEngineView($param = [])
    {
        return isset($param['exception']) && strpos(get_class($param['exception']), 'Exception') !== false;
    }

    protected function redirect($param, $controller = false)
    {
        if ($controller === false)
            $controller = $this->Name;
        $code = '200 OK';
        if (isset($param['code']))
            $code = $param['code'];
        header('HTTP/1.1 ' . $code);
        header('Location: ' . $this->arrayToURL($param, $controller));
    }

    protected function asJson($param)
    {
        header('Content-Type: application/json');
        return json_encode($param, JSON_UNESCAPED_UNICODE);
    }

    private function arrayToURL($param, $controller)
    {
        return WebApp::$URL->arrayToURL($param, $controller);
    }

    private function getActionMethod()
    {
        $action = 'action' . mb_strtoupper(mb_substr($this->Action, 0, 1), 'UTF-8');
        $action .= mb_substr($this->Action, 1, strlen($this->Action) - 1, 'UTF-8');
        // example: actionName
        return $action;
    }

    private function getViewFile($isEngineView)
    {
        return $isEngineView
            ? WebApp::$basePath . $this->ViewPath . $this->Name
            : WebApp::$home . $this->ViewPath . $this->Name;
    }

    private function getLayoutFile($isEngineView)
    {
        return $isEngineView
            ? WebApp::$basePath . $this->ViewPath . 'layout'
            : WebApp::$home . $this->ViewPath . 'layout';
    }

    private function getArgsForMethod($action)
    {
        $class = new \ReflectionClass($this);
        $param = $class->getMethod($action)->getParameters();

        $count = count($param);
        $GET = WebApp::$request->get();
        $notFound = null;

        for ($i = 0; $i < $count; $i++) {
            $notFound = $field = $param[$i]->name;
            foreach ($GET as $name => $value) {
                if ($field === $name) {
                    $notFound = null;
                    $args[] = $value;
                }
            }
            if ($notFound) {
                throw new Exceptions\ArgumentNotFoundException($notFound);
            }
        }

        return $args ?? [];
    }

    /**
     * Возвращает список методов класса
     *
     * @return array
     */
    private function getMethods()
    {
        return get_class_methods($this);
    }

}

<?php

namespace engine\base\controllers;

use engine\core\components\URLManager;
use engine\core\exceptions\ArgumentNotFoundException;
use engine\core\exceptions\FileNotFoundException;
use engine\App;
use engine\core\exceptions as Exceptions;
use engine\views\View;
use Exception;

/**
 * Базовый класс - Controller
 */

/// Базовый контроллер

class Controller implements IController
{
    /// Имя контроллера
    public string|array|null|false $Name;
    /// Действие
    public string|array|null|false $Action;
    /// Текущий URL
    public string $URL;
    /// Директория для представлений
    public string $ViewPath;
    /// Имя шаблона views
    public string $Layout;
    /// Массив параметров (breadcrumbs и т.д.)
    public array $params;
    /// Заголовок html-страницы
    public string $title;
    /// Формирование ответов по умолчанию в json
    public bool $isAjax = false;

    public const DEFAULT_LAYOUT = 'main';

    public function accessRights(): array
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

        $this->isAjax = $isAjax;
    }

    public function getViewPath(): string
    {
        return '/'. App::$config['namespace'] . '/views/';
    }

    /**
     * Действие по умолчанию (рендерниг index-страницы)
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function action(): string
    {
        return $this->render('index');
    }

    /**
     * Действие для controller/index (рендерниг index-страницы)
     *
     * @return string
     * @throws FileNotFoundException
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    /**
     * Страница ошибки по умолчанию (рендерниг error-страницы)
     *
     * @param Exception $exception
     * @return string
     * @throws FileNotFoundException
     */
    protected function error(Exception $exception): string
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
    public function execAction(): string
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

    private function checkAccess(): void
    {
        $right = App::$controller->accessRights();
        $isCan = App::$user->can();
        if (!$isCan && App::$user->isRule('*')) {
            throw new Exceptions\ForbiddenException($this->Action);
        }
        if (!$isCan) {
            $this->redirect([$right['redirect']['view']], $right['redirect']['controller']);
        }
    }

    /**
     * Функция рендеринга представления
     *
     * @param string $view
     * @param array $param
     * @return string
     * @throws FileNotFoundException
     */
    protected function render(string $view, array $param = []): string
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

    private function isEngineView($param = []): bool
    {
        return isset($param['exception']) && strpos(get_class($param['exception']), 'Exception') !== false;
    }

    protected function redirect($param, $controller = false): void
    {
        if ($controller === false)
            $controller = $this->Name;
        $code = '200 OK';
        if (isset($param['code']))
            $code = $param['code'];
        header('HTTP/1.1 ' . $code);
        header('Location: ' . $this->arrayToURL($param, $controller));
    }

    protected function asJson($param): false|string
    {
        header('Content-Type: application/json');
        return json_encode($param, JSON_UNESCAPED_UNICODE);
    }

    private function arrayToURL($param, $controller): array|string
    {
        return App::$URL->arrayToURL($param, $controller);
    }

    private function getActionMethod(): string
    {
        $action = 'action' . mb_strtoupper(mb_substr($this->Action, 0, 1), 'UTF-8');
        $action .= mb_substr($this->Action, 1, strlen($this->Action) - 1, 'UTF-8');
        // example: actionName
        return $action;
    }

    private function getViewFile($isEngineView): string
    {
        return $isEngineView
            ? App::$basePath . $this->ViewPath . $this->Name
            : App::$home . $this->ViewPath . $this->Name;
    }

    private function getLayoutFile($isEngineView): string
    {
        return App::$home . $this->ViewPath . 'layout';
    }

    /**
     * @throws \ReflectionException
     * @throws ArgumentNotFoundException
     */
    private function getArgsForMethod($action): array
    {
        $class = new \ReflectionClass($this);
        $param = $class->getMethod($action)->getParameters();

        $count = count($param);
        $GET = App::$request->get();
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
    private function getMethods(): array
    {
        return get_class_methods($this);
    }

}

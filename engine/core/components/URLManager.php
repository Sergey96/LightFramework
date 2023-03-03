<?php

namespace engine\core\components;

class URLManager
{
    public $Controller;
    public $Action;
    public $config;
    public $URL;

    public function __construct($config)
    {
        $this->config = $config;
        $this->URL = urldecode($_SERVER['REQUEST_URI']);
        $this->parseUrl();
    }

    public function parseUrl()
    {
        $this->Controller = $this->getController();
        $this->Action = $this->getAction();
    }

    private function getController()
    {
        if (preg_match_all('/^[\/]*[a-z]+/', $this->URL, $matches)) {
            $control = $matches[0][0];
            if (preg_match_all('/[a-z]+/', $control, $matches)) {
                $controller = $this->getFirstUpper($matches[0][0]);
            }
        }

        $controller = $controller ?? $this->config['controller']['default'];

        return $controller;
    }

    private function getAction()
    {
        if (preg_match_all('/^[\/]*[a-z]+[\/]+[a-z0-9]+/', $this->URL, $matches)) {
            $action = $matches[0][0];

            if (preg_match_all('/[a-z0-9]+$/', $action, $matches)) {
                return $matches[0][0];
            }
        }

        return 'index';
    }

    private function getFirstUpper($input)
    {
        $string = mb_strtoupper(mb_substr($input, 0, 1), 'UTF-8');
        $string .= mb_substr($input, 1, strlen($input) - 1, 'UTF-8');
        return $string;
    }

    public function getURL()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function getProtocol()
    {
        return strpos($_SERVER['SERVER_PROTOCOL'], "HTTPS") !== 0 ? 'https' : 'http';
    }

    public function arrayToURL($param, $controller)
    {
        $action = $param[0];
        $protocol = $this->getProtocol();
        $host = $this->getURL();

        $url = "$protocol://$host/$controller/$action";

        $count = 0;

        if (count($param) > 1) {
            $url .= '?';
        }

        foreach ($param as $field => $value) {
            $count++;
            if ($count == 1) {
                continue;
            }
            $url .= $field . '=' . $value . '&';
        }

        if (count($param) > 1) {
            $url = substr($url, 0, strlen($url) - 1);
        }

        return str_replace("\\", "/", $url);
    }

}

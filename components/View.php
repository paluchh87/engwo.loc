<?php

namespace components;

class View
{
    public $path;
    public $route;
    public $layout = 'main';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['name'] . '/' . $route['action'];
    }

    public function render($title, $vars = [])
    {
        extract($vars);
        $path = ROOT . '/views/' . $this->path . '.php';
        if (file_exists($path)) {
            ob_start();
            require_once($path);
            $content = ob_get_clean();
            require_once(ROOT . '/views/layouts/' . $this->layout . '.php');
        }
    }

    public static function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

    public static function errorCode($code)
    {
        $path = ROOT . '/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require_once($path);
        }
        exit;
    }
}

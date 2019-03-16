<?php

namespace components;

abstract class Controller
{
    public $route;
    public $view;
    public $access;
    public $model;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['name']);

        if (!$this->checkAccess()) {
            $this->view->redirect('/engwo/login');
        }
    }

    public function loadModel($name)
    {
        $path = 'models\\' . $name;

        return new $path;
    }

    public function checkAccess()
    {
        $path = ROOT . '/access/' . $this->route['name'] . '.php';
        if (!file_exists($path)) {
            return false;
        }
        $this->access = require_once($path);

        if ($this->model->isLoggedIn() AND $this->isAccess('authorize')) {
            return true;
        }
        if (!$this->model->isLoggedIn() AND $this->isAccess('guest')) {
            return true;
        }

//        if (isset($_SESSION['auth_username']) and isset($_SESSION['admin']) and $this->isAcl('admin')) {
//            return true;
//        }

        return false;
    }

    public function isAccess($key)
    {
        return in_array($this->route['action'], $this->access[$key]);
    }
}
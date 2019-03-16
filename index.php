<?php

use components\Router;

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/lib/Dev.php');
require_once(ROOT . '/vendor/autoload.php');

session_start(['cookie_lifetime' => 1800]);
try {
    $router = new Router();
    $router->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
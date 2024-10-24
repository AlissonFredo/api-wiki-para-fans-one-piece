<?php

namespace app\core;

use app\core\Router;
use app\controllers\PersonageController;

class Main
{
    static function initialize()
    {
        $router = new Router();

        $router->addRoute("POST", "/personages", PersonageController::class, 'create');
        $router->addRoute("PUT", "/personages", PersonageController::class, 'update');
        $router->addRoute("GET", "/personages/list", PersonageController::class, 'list');
        $router->addRoute("GET", "/personages/show", PersonageController::class, 'showById');
        $router->addRoute("DELETE", "/personages", PersonageController::class, 'destroy');
        $router->addRoute("GET", "/personages/search", PersonageController::class, 'searchByName');

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $router->dispatch($method, $uri);
    }
}

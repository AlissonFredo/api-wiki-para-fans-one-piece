<?php

namespace app\core;

use app\core\Router;
use app\controllers\CharacterController;
use app\core\Config;

class Main
{
    static function initialize()
    {
        Config::load(__DIR__ . "/../../.env");

        $router = new Router();

        $router->addRoute("POST", "/characters", CharacterController::class, 'create');
        $router->addRoute("PUT", "/characters", CharacterController::class, 'update');
        $router->addRoute("GET", "/characters/list", CharacterController::class, 'list');
        $router->addRoute("GET", "/characters/show", CharacterController::class, 'showById');
        $router->addRoute("DELETE", "/characters", CharacterController::class, 'destroy');
        $router->addRoute("GET", "/characters/search", CharacterController::class, 'searchByName');

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $router->dispatch($method, $uri);
    }
}

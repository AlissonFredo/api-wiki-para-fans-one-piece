<?php

namespace app\core;

use app\core\Router;
use app\core\Config;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API for One Piece fans",
 *     version="1.14.0"
 * )
 */
class Main
{
    static function initialize()
    {
        Config::load(__DIR__ . "/../../.env");

        $router = new Router();
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $router->dispatch($method, $uri);
    }
}

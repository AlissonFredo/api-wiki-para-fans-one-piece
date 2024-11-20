<?php

namespace app\core;

use app\controllers\CharacterController;
use app\controllers\DocsController;

class Router
{
    private $routes = [];

    public function __construct()
    {
        $this->addRoute("GET", "/documentation", DocsController::class, 'docs');
        $this->addRoute("GET", "/documentation/assets", DocsController::class, 'asset');
        $this->addRoute("POST", "/characters", CharacterController::class, 'create');
        $this->addRoute("PUT", "/characters", CharacterController::class, 'update');
        $this->addRoute("GET", "/characters/list", CharacterController::class, 'list');
        $this->addRoute("GET", "/characters/show", CharacterController::class, 'showById');
        $this->addRoute("DELETE", "/characters", CharacterController::class, 'destroy');
        $this->addRoute("GET", "/characters/search", CharacterController::class, 'searchByName');
    }

    private function addRoute($method, $path, $controller, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                $controller = new $route['controller'];
                $action = $route['action'];
                $params = $_GET;
                $request = [];

                if ($method === 'POST' || $method === 'PUT') {
                    $request = json_decode(file_get_contents('php://input'), true);
                }

                $response = null;

                if ($method === 'GET' || $method === 'DELETE') {
                    $response = $controller->$action($params);
                } elseif ($method === 'PUT') {
                    $response = $controller->$action($request, $params);
                } elseif ($method === 'POST') {
                    $response = $controller->$action($request);
                }

                if ($response !== null) {
                    echo $response;
                }

                return;
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'route not found']);
    }
}

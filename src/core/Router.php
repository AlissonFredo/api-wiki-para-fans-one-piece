<?php

namespace app\core;

class Router
{
    private $routes = [];

    public function addRoute($method, $path, $controller, $action)
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
                    header('Content-Type: application/json');
                    echo $response;
                }

                return;
            }
        }

        http_response_code(404);
        echo json_encode(['message' => 'route not found']);
    }
}

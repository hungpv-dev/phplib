<?php

namespace App\Http;

class CustomRoute
{
    protected static $routes = [];

    public static function get($uri, $action)
    {
        self::addRoute('GET', $uri, $action);
    }

    public static function post($uri, $action)
    {
        self::addRoute('POST', $uri, $action);
    }

    public static function put($uri, $action)
    {
        self::addRoute('PUT', $uri, $action);
    }

    public static function delete($uri, $action)
    {
        self::addRoute('DELETE', $uri, $action);
    }

    protected static function addRoute($method, $uri, $action)
    {
        self::$routes[] = compact('method', 'uri', 'action');
    }

    public static function dispatch($request)
    {
        $requestMethod = $request->getMethod();
        $requestUri = $request->getPathInfo();

        foreach (self::$routes as $route) {
            if ($route['method'] === $requestMethod && $route['uri'] === $requestUri) {
                return self::executeAction($route['action']);
            }
        }

        return self::sendNotFoundResponse();
    }

    protected static function executeAction($action)
    {
        if (is_callable($action)) {
            return call_user_func($action);
        } elseif (is_string($action)) {
            list($controller, $method) = explode('@', $action);
            $controller = "App\\Http\\Controllers\\{$controller}";
            return call_user_func_array([new $controller, $method], []);
        }
    }

    protected static function sendNotFoundResponse()
    {
        http_response_code(404);
        echo "404 Not Found";
    }
}
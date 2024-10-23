<?php

declare(strict_types=1);

namespace App;

class Router {
    private array $routes;

    public function register(string $requestMethod, string $route, callable|array $action): void {
        $this->routes[$requestMethod][$route] = $action;
    }

    public function get(string $route, callable|array $action): void {
        $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): void {
        $this->register('post', $route, $action);
    }

    public function routes(): array {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod): mixed {
        if (! ctype_lower($requestMethod)) {
            $requestMethod = strtolower($requestMethod);
        }
        $route = explode('?', $requestUri)[0];

        $action = $this->routes[$requestMethod][$route];

        if (!$action) {
            throw new \App\Exceptions\PageNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        } else {
            [$class, $method] = $action;
            return call_user_func_array([$class, $method], []);
        }
    }
}


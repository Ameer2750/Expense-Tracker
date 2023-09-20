<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function add(string $method, string $path, array $controller)
    {
        $normalized_path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $normalized_path,
            'method' => strtoupper($method),
            'controller' => $controller
        ];
    }

    public function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        return preg_replace('#[/]{2,}#', '/',  $path);
    }

    public function  dispatch(string $path, string $method, Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            [$class, $function] = $route['controller'];

            $controllerInstance = $container ? $container->resolve($class) :  new $class;

            $controllerInstance->$function();
        }
    }

    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}

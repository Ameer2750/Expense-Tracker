<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path)
    {
        $normalized_path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $normalized_path,
            'method' => strtoupper($method)
        ];
    }

    public function normalizePath(string $path): string
    {
        $trim_value = trim($path, '/');
        return "/{$trim_value}/";
    }
}

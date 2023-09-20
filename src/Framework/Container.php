<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass;
use Framework\Exceptions\ContainerException;

class Container
{
    private array $definitions = [];

    public function addDefintions(array $newDefinition)
    {
        $this->definitions = [...$this->definitions, ...$newDefinition];
    }

    public function resolve(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("class {$className} is Not Instantiable");
        }

        dd($reflectionClass);
    }
}

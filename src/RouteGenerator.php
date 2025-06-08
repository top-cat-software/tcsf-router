<?php

namespace TCSF\Router;

use ReflectionClass;
use ReflectionMethod;
use TCSF\Router\Attributes\Route as RouteAttribute;

/**
 * Generates routes by scanning classes for Route attributes.
 */
class RouteGenerator
{
    /**
     * @var Route[] Array of generated routes
     */
    private array $routes = [];

    /**
     * Scan a class for methods with Route attributes and generate routes.
     *
     * @param string $className Fully qualified class name to scan
     * @return void
     */
    public function scanClass(string $className): void
    {
        $reflectionClass = new ReflectionClass($className);

        foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $attributes = $method->getAttributes(RouteAttribute::class);

            foreach ($attributes as $attribute) {
                /** @var RouteAttribute $routeAttribute */
                $routeAttribute = $attribute->newInstance();

                $this->routes[] = new \TCSF\Router\Route(
                    $routeAttribute->path,
                    $routeAttribute->methods,
                    $className,
                    $method->getName()
                );
            }
        }
    }

    /**
     * Scan multiple classes for routes.
     *
     * @param string[] $classNames Array of fully qualified class names to scan
     * @return void
     */
    public function scanClasses(array $classNames): void
    {
        foreach ($classNames as $className) {
            $this->scanClass($className);
        }
    }

    /**
     * Get all generated routes.
     *
     * @return Route[] Array of generated routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
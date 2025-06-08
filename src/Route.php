<?php

namespace TCSF\Router;

/**
 * Represents a single route in the routing system.
 */
class Route
{
    /**
     * @param string $path The URL path pattern for this route
     * @param array<HttpMethod> $methods The HTTP methods this route responds to
     * @param string $className The fully qualified class name containing the handler
     * @param string $methodName The method name to call when this route is matched
     */
    public function __construct(
        private string $path,
        private array $methods,
        private string $className,
        private string $methodName
    ) {
    }

    /**
     * Get the URL path pattern for this route.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get the primary HTTP method this route responds to.
     * For backward compatibility, returns the first method in the array.
     */
    public function getMethod(): string
    {
        return $this->methods[0]->value;
    }

    /**
     * Get all HTTP methods this route responds to.
     * 
     * @return array<HttpMethod> Array of HTTP methods
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Get the fully qualified class name containing the handler.
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Get the method name to call when this route is matched.
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }
}

<?php

namespace TCSF\Router;

/**
 * Router that matches incoming requests to routes and dispatches them to handlers.
 */
class Router
{
    /**
     * @param Route[] $routes Array of routes to use for routing
     */
    public function __construct(
        private array $routes = []
    ) {
    }

    /**
     * Add routes to the router.
     *
     * @param Route[] $routes Array of routes to add
     * @return void
     */
    public function addRoutes(array $routes): void
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    /**
     * Get all routes registered with the router.
     *
     * @return Route[] Array of routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Match a request path and method to a route.
     *
     * @param string $path The request path to match
     * @param string $method The HTTP method to match
     * @return Route|null The matched route or null if no match found
     */
    public function match(string $path, string $method): ?Route
    {
        foreach ($this->routes as $route) {
            // Simple exact path matching for now
            if ($route->getPath() === $path) {
                // Check if any of the route's methods match the requested method
                foreach ($route->getMethods() as $routeMethod) {
                    if ($routeMethod->value === $method) {
                        return $route;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Dispatch a request to the appropriate handler.
     *
     * @param string $path The request path to dispatch
     * @param string $method The HTTP method of the request
     * @return mixed The result of the handler
     * @throws \RuntimeException If no matching route is found
     */
    public function dispatch(string $path, string $method): mixed
    {
        $route = $this->match($path, $method);

        if ($route === null) {
            throw new \RuntimeException("No route found for $method $path");
        }

        $className = $route->getClassName();
        $methodName = $route->getMethodName();

        $instance = new $className();
        return $instance->$methodName();
    }
}

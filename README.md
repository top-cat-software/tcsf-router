# TCSF Router

A PHP router library that generates routes from attributes, part of the Top Cat Software Framework.

## Features

- Define routes using PHP 8.4 attributes
- Automatically generates routes from controller classes
- Simple and intuitive API
- Support for different HTTP methods (GET, POST, etc.)
- Designed for future caching support

## Requirements

- PHP 8.4 or higher

## Installation

```bash
composer require top-cat-software/tcsf-router
```

## Basic Usage

### Define a Controller with Route Attributes

```php
use TCSF\Router\Attributes\Route;
use TCSF\Router\HttpMethod;

class MyController
{
    #[Route(path: '/')]
    public function home(): string
    {
        return 'Welcome to the home page!';
    }

    #[Route(path: '/about')]
    public function about(): string
    {
        return 'About us page';
    }

    #[Route(path: '/contact', methods: [HttpMethod::POST])]
    public function contact(): string
    {
        return 'Thank you for your message!';
    }
}
```

### Generate Routes and Create Router

```php
use TCSF\Router\RouteGenerator;
use TCSF\Router\Router;

// Generate routes from controller class
$generator = new RouteGenerator();
$generator->scanClass(MyController::class);
$routes = $generator->getRoutes();

// Create router with generated routes
$router = new Router($routes);
```

### Handle Requests

```php
// Get the current request path and method
$path = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    // Dispatch the request to the appropriate handler
    $response = $router->dispatch($path, $method);
    echo $response;
} catch (\RuntimeException $e) {
    // Handle 404 Not Found
    http_response_code(404);
    echo '404 Not Found: ' . $e->getMessage();
}
```

## Future Caching Support

The router is designed to support caching of routes. While not yet implemented, the API is ready for it:

```php
// Get all routes for caching
$allRoutes = $router->getRoutes();

// In a real application, you would serialize and cache these routes
$cachedRoutes = serialize($allRoutes);
file_put_contents('routes.cache', $cachedRoutes);

// Later, you could load the cached routes instead of scanning classes
$cachedRoutes = file_get_contents('routes.cache');
$routes = unserialize($cachedRoutes);
$router = new Router($routes);
```

## License

MIT

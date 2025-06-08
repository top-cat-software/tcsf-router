<?php

namespace TCSF\Router\Tests;

use PHPUnit\Framework\TestCase;
use TCSF\Router\HttpMethod;
use TCSF\Router\Route;
use TCSF\Router\Router;
use TCSF\Router\RouteGenerator;

class RouterTest extends TestCase
{
    private Router $router;
    private RouteGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new RouteGenerator();
        $this->generator->scanClass(TestController::class);

        $this->router = new Router($this->generator->getRoutes());
    }

    public function testGetRoutes(): void
    {
        $routes = $this->router->getRoutes();

        $this->assertCount(2, $routes);
        $this->assertContainsOnlyInstancesOf(Route::class, $routes);
    }

    public function testAddRoutes(): void
    {
        $router = new Router();
        $this->assertCount(0, $router->getRoutes());

        $router->addRoutes($this->generator->getRoutes());
        $this->assertCount(2, $router->getRoutes());
    }

    public function testMatch(): void
    {
        // Test matching GET route
        $route = $this->router->match('/test/get', 'GET');
        $this->assertNotNull($route);
        $this->assertSame('/test/get', $route->getPath());
        $this->assertSame('GET', $route->getMethod());

        // Test matching POST route
        $route = $this->router->match('/test/post', 'POST');
        $this->assertNotNull($route);
        $this->assertSame('/test/post', $route->getPath());
        $this->assertSame('POST', $route->getMethod());

        // Test non-matching path
        $route = $this->router->match('/not/found', 'GET');
        $this->assertNull($route);

        // Test non-matching method
        $route = $this->router->match('/test/get', 'POST');
        $this->assertNull($route);
    }

    public function testDispatch(): void
    {
        // Test dispatching GET route
        $result = $this->router->dispatch('/test/get', 'GET');
        $this->assertSame('Test GET', $result);

        // Test dispatching POST route
        $result = $this->router->dispatch('/test/post', 'POST');
        $this->assertSame('Test POST', $result);
    }

    public function testDispatchThrowsExceptionForNonMatchingRoute(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->router->dispatch('/not/found', 'GET');
    }
}

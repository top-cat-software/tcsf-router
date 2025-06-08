<?php

namespace TCSF\Router\Tests;

use PHPUnit\Framework\TestCase;
use TCSF\Router\RouteGenerator;

class RouteGeneratorTest extends TestCase
{
    public function testScanClass(): void
    {
        $generator = new RouteGenerator();
        $generator->scanClass(TestController::class);

        $routes = $generator->getRoutes();

        // Should find 2 routes (GET and POST, but not the private method)
        $this->assertCount(2, $routes);

        // Check the GET route
        $getRoute = null;
        $postRoute = null;

        foreach ($routes as $route) {
            if ($route->getMethod() === 'GET') {
                $getRoute = $route;
            } elseif ($route->getMethod() === 'POST') {
                $postRoute = $route;
            }
        }

        $this->assertNotNull($getRoute);
        $this->assertSame('/test/get', $getRoute->getPath());
        $this->assertSame(TestController::class, $getRoute->getClassName());
        $this->assertSame('testGet', $getRoute->getMethodName());

        // Check the POST route
        $this->assertNotNull($postRoute);
        $this->assertSame('/test/post', $postRoute->getPath());
        $this->assertSame(TestController::class, $postRoute->getClassName());
        $this->assertSame('testPost', $postRoute->getMethodName());
    }

    public function testScanClasses(): void
    {
        $generator = new RouteGenerator();
        $generator->scanClasses([TestController::class]);

        $routes = $generator->getRoutes();

        // Should find 2 routes
        $this->assertCount(2, $routes);
    }
}

<?php

namespace TCSF\Router\Tests;

use PHPUnit\Framework\TestCase;
use TCSF\Router\HttpMethod;
use TCSF\Router\Route;

class RouteTest extends TestCase
{
    public function testRouteStoresAndRetrievesValues(): void
    {
        $path = '/test/path';
        $methods = [HttpMethod::GET];
        $className = 'TestController';
        $methodName = 'testMethod';

        $route = new Route($path, $methods, $className, $methodName);

        $this->assertSame($path, $route->getPath());
        $this->assertSame('GET', $route->getMethod());
        $this->assertSame($methods, $route->getMethods());
        $this->assertSame($className, $route->getClassName());
        $this->assertSame($methodName, $route->getMethodName());
    }
}

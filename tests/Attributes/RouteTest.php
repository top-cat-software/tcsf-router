<?php

namespace TCSF\Router\Tests\Attributes;

use PHPUnit\Framework\TestCase;
use TCSF\Router\Attributes\Route;
use TCSF\Router\HttpMethod;

class RouteTest extends TestCase
{
    public function testRouteStoresAndRetrievesValues(): void
    {
        $path = '/test/path';
        $methods = [HttpMethod::POST, HttpMethod::PUT];

        $attribute = new Route($path, $methods);

        $this->assertSame($path, $attribute->path);
        $this->assertSame($methods, $attribute->methods);
    }

    public function testRouteUsesDefaultMethod(): void
    {
        $path = '/test/path';

        $attribute = new Route($path);

        $this->assertSame($path, $attribute->path);
        $this->assertSame([HttpMethod::GET], $attribute->methods);
    }
}

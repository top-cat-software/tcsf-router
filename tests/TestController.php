<?php

namespace TCSF\Router\Tests;

use TCSF\Router\Attributes\Route;
use TCSF\Router\HttpMethod;

/**
 * Test controller class for testing the RouteGenerator.
 */
class TestController
{
    /**
     * Test method with a GET route.
     */
    #[Route(path: '/test/get')]
    public function testGet(): string
    {
        return 'Test GET';
    }

    /**
     * Test method with a POST route.
     */
    #[Route(path: '/test/post', methods: [HttpMethod::POST])]
    public function testPost(): string
    {
        return 'Test POST';
    }

    /**
     * Test method with no route attribute.
     */
    public function testNoRoute(): string
    {
        return 'No Route';
    }

    /**
     * Private method that should be ignored by the route generator.
     */
    #[Route(path: '/test/private')]
    private function testPrivate(): string
    {
        return 'Private';
    }
}

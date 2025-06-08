<?php

namespace TCSF\Router;

/**
 * Enum representing HTTP methods.
 * This ensures that only valid HTTP methods are used in routes.
 */
enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
    case OPTIONS = 'OPTIONS';
    case HEAD = 'HEAD';
}
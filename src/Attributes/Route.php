<?php

namespace TCSF\Router\Attributes;

use Attribute;
use TCSF\Router\Exceptions\InvalidHttpMethodException;
use TCSF\Router\HttpMethod;

/**
 * Attribute to define a route on a controller method.
 * 
 * Uses PHP 8.4 property hooks pattern for accessing private properties.
 */
#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    /**
     * @param string $path The URL path pattern for this route
     * @param array<HttpMethod> $methods The HTTP methods this route responds to
     */
    public function __construct(
        private(set) readonly string $path,
        private(set) array $methods = [HttpMethod::GET] {
            set(array $methods) {
                $invalidMethods = [];
                foreach ($methods as $method) {
                    if (!$method instanceof HttpMethod) {
                        if (is_string($method)) {
                            $invalidMethods[] = $method;
                        } elseif (is_object($method)) {
                            $invalidMethods[] = get_class($method);
                        } else {
                            $invalidMethods[] = "Invalid type: " . gettype($method);
                        }
                    }
                }
                if (!empty($invalidMethods)) {
                    throw new InvalidHttpMethodException(
                        'Invalid HTTP method(s) provided: ' . implode(', ', $invalidMethods)
                    );
                }

                $this->methods = $methods;
            }
        }
    ) {
    }
}

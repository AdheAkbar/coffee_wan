<?php

/**
 * Router — URL dispatcher
 * Coffee Export B2B
 *
 * Supports GET and POST route registration with controller dispatch.
 * Route parameters use {param} syntax, e.g. /catalog/{slug}
 */

namespace Core;

class Router
{
    private array $routes = [];

    /**
     * Register a GET route.
     */
    public function get(string $uri, string $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Register a POST route.
     */
    public function post(string $uri, string $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    private function addRoute(string $method, string $uri, string $action): void
    {
        // Normalise: ensure leading slash, no trailing slash
        $uri = '/' . ltrim(rtrim($uri, '/'), '/');

        $this->routes[] = [
            'method'  => $method,
            'uri'     => $uri,
            'pattern' => $this->buildPattern($uri),
            'action'  => $action,
        ];
    }

    /**
     * Convert {param} segments to named regex capture groups.
     */
    private function buildPattern(string $uri): string
    {
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $uri);
        return '#^' . $pattern . '$#';
    }

    /**
     * Match the incoming request to a route and dispatch.
     */
    public function dispatch(Request $request): void
    {
        $method = $request->method;
        $uri    = '/' . ltrim(rtrim($request->uri, '/'), '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                // Extract named params only
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->callAction($route['action'], $request, $params);
                return;
            }
        }

        // No route matched → 404
        $this->notFound();
    }

    /**
     * Resolve "ControllerClass@method" and invoke it.
     */
    private function callAction(string $action, Request $request, array $params): void
    {
        [$class, $method] = explode('@', $action, 2);
        $fqcn = "App\\Controllers\\{$class}";

        if (!class_exists($fqcn)) {
            throw new \RuntimeException("Controller [{$fqcn}] not found.");
        }

        $controller = new $fqcn();

        if (!method_exists($controller, $method)) {
            throw new \RuntimeException("Method [{$method}] not found on [{$fqcn}].");
        }

        $controller->$method($request, $params);
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 — Page Not Found</h1>';
        exit;
    }
}

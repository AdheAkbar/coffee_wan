<?php

/**
 * HTTP Request Abstraction
 * Coffee Export B2B
 */

namespace Core;

class Request
{
    public string $method;
    public string $uri;
    public array  $query;
    public array  $body;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->uri    = $this->parseUri();
        $this->query  = $_GET  ?? [];
        $this->body   = $_POST ?? [];
    }

    private function parseUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // Strip query string
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }

        // Strip the sub-directory prefix if running in a subdirectory
        $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        if ($scriptDir !== '/' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        return '/' . ltrim($uri, '/');
    }

    public function isPost(): bool { return $this->method === 'POST'; }
    public function isGet():  bool { return $this->method === 'GET';  }

    /**
     * Get a value from POST body with optional default.
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function input(string $key, $default = null)
    {
        return $this->body[$key] ?? $default;
    }

    /**
     * Get a value from query string with optional default.
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function query(string $key, $default = null)
    {
        return $this->query[$key] ?? $default;
    }

    /**
     * Sanitize and return a string input.
     * @param string $key
     * @param mixed $default
     * @return string
     */
    public function safe(string $key, $default = ''): string
    {
        $val = $this->input($key, $default);
        return htmlspecialchars(trim((string) $val), ENT_QUOTES, 'UTF-8');
    }
}

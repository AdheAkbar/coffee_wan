<?php

/**
 * Base Controller
 * Coffee Export B2B
 *
 * All application controllers extend this class.
 * Provides view rendering, redirects, and JSON responses.
 */

namespace Core;

class Controller
{
    protected array $appConfig = [];
    protected array $dbConfig  = [];

    public function __construct()
    {
        $this->appConfig = require ROOT_PATH . '/config/app.php';
    }

    /**
     * Render a view template inside the master layout.
     *
     * @param string $view   Dot-notation path relative to resources/views/
     *                       e.g. 'pages.home' → resources/views/pages/home.php
     * @param array  $data   Variables to extract into the view scope
     * @param string $layout Layout file name (without extension)
     */
    protected function render(string $view, array $data = [], string $layout = 'app'): void
    {
        // Make app config available in all views
        $data['appConfig'] = $this->appConfig;

        // Convert dot notation to file path
        $viewPath   = $this->resolvePath($view);
        $layoutPath = ROOT_PATH . "/resources/views/layouts/{$layout}.php";

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View [{$view}] not found at [{$viewPath}].");
        }

        // Extract data into local scope
        extract($data, EXTR_SKIP);

        // Capture view content into $content variable
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        // Render inside layout
        include $layoutPath;
    }

    /**
     * Render a view partial snippet (no layout wrapper).
     */
    protected function partial(string $view, array $data = []): string
    {
        $path = $this->resolvePath($view);
        extract($data, EXTR_SKIP);

        ob_start();
        include $path;
        return ob_get_clean();
    }

    /**
     * Send a JSON response.
     */
    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Redirect to a URL.
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Convert dot-notation view name to absolute file path.
     */
    private function resolvePath(string $view): string
    {
        $relative = str_replace('.', '/', $view);
        return ROOT_PATH . "/resources/views/{$relative}.php";
    }
}

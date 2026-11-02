<?php

/**
 * Application Bootstrap
 * Coffee Export B2B
 *
 * Wires together the router, autoloader, and request lifecycle.
 */

namespace Core;

class App
{
    private Router $router;

    public function __construct()
    {
        $this->registerAutoloader();
        $this->router = new Router();
    }

    /**
     * Load route definitions and dispatch the current request.
     */
    public function run(): void
    {
        $request = new Request();

        // Load route definitions (they call $router->get() / $router->post())
        $router = $this->router;
        require ROOT_PATH . '/routes/web.php';

        $this->router->dispatch($request);
    }

    /**
     * PSR-4-style autoloader for App\ and Core\ namespaces.
     *
     * Namespace → directory mapping:
     *   Core\  → /core/
     *   App\   → /app/
     */
    private function registerAutoloader(): void
    {
        spl_autoload_register(function (string $class): void {
            $namespaceMap = [
                'Core\\' => ROOT_PATH . '/core/',
                'App\\'  => ROOT_PATH . '/app/',
            ];

            foreach ($namespaceMap as $prefix => $baseDir) {
                if (str_starts_with($class, $prefix)) {
                    $relative = substr($class, strlen($prefix));
                    $file     = $baseDir . str_replace('\\', '/', $relative) . '.php';

                    if (file_exists($file)) {
                        require_once $file;
                        return;
                    }
                }
            }
        });
    }
}

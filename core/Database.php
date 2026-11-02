<?php

/**
 * Database Singleton — PDO wrapper
 * Coffee Export B2B
 */

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;
    private static array $config  = [];

    /**
     * Get the singleton PDO instance.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$config = require ROOT_PATH . '/config/database.php';
            self::connect();
        }

        return self::$instance;
    }

    private static function connect(): void
    {
        $cfg = self::$config;
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s;charset=%s',
            $cfg['driver'],
            $cfg['host'],
            $cfg['port'],
            $cfg['database'],
            $cfg['charset']
        );

        try {
            self::$instance = new PDO(
                $dsn,
                $cfg['username'],
                $cfg['password'],
                $cfg['options']
            );
        } catch (PDOException $e) {
            // In production, log this rather than echoing
            http_response_code(500);
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    // Prevent instantiation / cloning
    private function __construct() {}
    private function __clone()     {}
}

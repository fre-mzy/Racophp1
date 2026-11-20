
<?php
declare(strict_types=1);

namespace Raco\Portal\Database;

use PDO;
use RuntimeException;
use PDOException;

final class Connection
{
    private static ?PDO $instance = null;

    private function __construct() {}

    public static function get(): PDO
    {
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        if (!extension_loaded('pdo_pgsql')) {
            throw new RuntimeException(
                'The PHP PostgreSQL PDO extension is not installed.'
            );
        }

        $host = \raco_env('DB_HOST', '127.0.0.1');
        $port = \raco_env('DB_PORT', '5432');
        $database = \raco_env('DB_DATABASE');
        $username = \raco_env('DB_USERNAME');
        $password = \raco_env('DB_PASSWORD');

        if (!$database || !$username || !$password) {
            throw new RuntimeException(
                'Database configuration is incomplete.'
            );
        }

        if (!ctype_digit($port) || (int)$port < 1 || (int)$port > 65535) {
            throw new RuntimeException('Invalid database port.');
        }

        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $host,
            $port,
            $database
        );

        try {
            self::$instance = new PDO(
                $dsn,
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            return self::$instance;
        } catch (PDOException $exception) {
            throw new RuntimeException(
                'Database connection failed. Check server configuration.',
                0,
                $exception
            );
        }
    }
}

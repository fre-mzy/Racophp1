
<?php
declare(strict_types=1);

/**
 * RACO Management Portal
 * Application bootstrap
 *
 * This is separate from the existing public website configuration.
 * Never put passwords or secret keys in this file.
 */

if (!defined('RACO_PORTAL_ROOT')) {
    define('RACO_PORTAL_ROOT', dirname(__DIR__));
}

/**
 * Read an environment variable safely.
 */
if (!function_exists('raco_env')) {
    function raco_env(string $key, ?string $default = null): ?string
    {
        $value = getenv($key);

        if ($value === false || $value === '') {
            return $default;
        }

        return $value;
    }
}

/**
 * Application environment.
 */
if (!defined('RACO_PORTAL_ENV')) {
    define('RACO_PORTAL_ENV', raco_env('APP_ENV', 'production'));
}

/**
 * Debugging must remain disabled in production.
 */
if (!defined('RACO_PORTAL_DEBUG')) {
    define(
        'RACO_PORTAL_DEBUG',
        filter_var(
            raco_env('APP_DEBUG', 'false'),
            FILTER_VALIDATE_BOOLEAN
        )
    );
}

/**
 * Application timezone.
 */
date_default_timezone_set(
    raco_env('APP_TIMEZONE', 'Africa/Lagos')
);

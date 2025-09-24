<?php
declare(strict_types=1);

/**
 * Application bootstrap file
 * - Loads Composer autoloader
 * - Loads environment variables (from .env in dev)
 * - Starts secure sessions
 * - Establishes PDO database connection
 * - Sets some typical defaults (error handling, timezone)
 */

// 0) Composer autoload
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!is_file($autoloadPath)) {
    throw new RuntimeException("Composer autoload not found at {$autoloadPath}. Did you run `composer install`?");
}
require $autoloadPath;

// 1) Load environment variables BEFORE using $_ENV
$projectRoot = dirname(__DIR__ . '/app'); // one level up from /bootstrap
$envPath     = $projectRoot . '/.env';

if (is_file($envPath)) {
    // safeLoad() won’t overwrite existing server vars; enough for most deployments
    $dotenv = Dotenv\Dotenv::createImmutable($projectRoot);
    $dotenv->safeLoad();
}

// Merge a read-only snapshot for convenience (env wins over server)
$env = array_merge($_SERVER, $_ENV);

// 2) Error reporting & timezone (now that env is loaded)
$envApp = $env['APP_ENV'] ?? 'prod';
$isProd = ($envApp === 'prod');

error_reporting(E_ALL);
ini_set('display_errors', $isProd ? '0' : '1');

date_default_timezone_set($env['APP_TZ'] ?? 'UTC');

// 3) Session setup (with secure defaults)
if (session_status() === PHP_SESSION_NONE) {
    // Robust HTTPS detection
    $isHttps = (
        (!empty($_SERVER['HTTPS']) && strtolower((string)$_SERVER['HTTPS']) !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
        || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower((string)$_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https')
    );

    session_start([
        'cookie_httponly' => true,          // prevent JS from reading session cookie
        'cookie_secure'   => $isHttps,      // only over HTTPS
        'cookie_samesite' => 'Lax',         // mitigate CSRF
        'use_strict_mode' => 1,             // mitigates fixation
        // You can set a custom name if you like:
        // 'name' => 'TRLSESSID',
    ]);
}

// 4) PDO database connection (strict + flexible)
$require = function (array $keys, array $envVars): void {
    foreach ($keys as $k) {
        // allow DB_PASS to be empty string but still "set"
        if (!array_key_exists($k, $envVars) || ($k !== 'DB_PASS' && trim((string)$envVars[$k]) === '')) {
            throw new RuntimeException("Missing required environment variable: {$k}");
        }
    }
};

try {
    // Require essentials. Allow either host or unix socket.
    $hasSocket = !empty($env['DB_SOCKET']);
    if ($hasSocket) {
        $require(['DB_SOCKET', 'DB_NAME', 'DB_USER', 'DB_PASS'], $env);
    } else {
        $require(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'], $env);
    }

    // Build DSN (host/port or unix socket)
    if ($hasSocket) {
        $dsn = sprintf(
            'mysql:unix_socket=%s;dbname=%s;charset=utf8mb4',
            $env['DB_SOCKET'],
            $env['DB_NAME']
        );
    } else {
        $port = isset($env['DB_PORT']) && (string)$env['DB_PORT'] !== '' ? (int)$env['DB_PORT'] : 3306;
        $dsn  = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $env['DB_HOST'],
            $port,
            $env['DB_NAME']
        );
    }

    // Common PDO options
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // Optional SSL (if you use managed MySQL that requires SSL)
    // Provide any of these in the environment to enable SSL:
    // DB_SSL_CA, DB_SSL_CERT, DB_SSL_KEY
    if (!empty($env['DB_SSL_CA']) || !empty($env['DB_SSL_CERT']) || !empty($env['DB_SSL_KEY'])) {
        // These MySQL attributes are available if pdo_mysql is compiled with SSL
        // (Suppress if not defined in your environment)
        if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
            $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false; // adjust as needed
        }
        if (!empty($env['DB_SSL_CA']) && defined('PDO::MYSQL_ATTR_SSL_CA')) {
            $options[PDO::MYSQL_ATTR_SSL_CA] = $env['DB_SSL_CA'];
        }
        if (!empty($env['DB_SSL_CERT']) && defined('PDO::MYSQL_ATTR_SSL_CERT')) {
            $options[PDO::MYSQL_ATTR_SSL_CERT] = $env['DB_SSL_CERT'];
        }
        if (!empty($env['DB_SSL_KEY']) && defined('PDO::MYSQL_ATTR_SSL_KEY')) {
            $options[PDO::MYSQL_ATTR_SSL_KEY] = $env['DB_SSL_KEY'];
        }
    }

    $pdo = new PDO($dsn, (string)$env['DB_USER'], (string)$env['DB_PASS'], $options);

    // Optional: align DB session time zone with app
    if (!empty($env['DB_TIMEZONE'])) {
        $stmt = $pdo->prepare("SET time_zone = :tz");
        $stmt->execute([':tz' => $env['DB_TIMEZONE']]);
    }
} catch (Throwable $e) {
    if ($isProd) {
        error_log('Database bootstrap error: ' . $e->getMessage());
        http_response_code(500);
        die('Database connection failed.');
    }
    // Dev: show the actual error to help diagnose
    http_response_code(500);
    die('Database connection failed: ' . $e->getMessage());
}

// 5) Return useful objects to entry points
return [
    'pdo' => $pdo,
    'env' => $env, // merged snapshot
];

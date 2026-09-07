<?php
/**
 * functions.php
 * Shared backend utilities: DB connection, JSON helpers, input cleaning,
 * and a lightweight file-based rate limiter for the contact form.
 */

require_once __DIR__ . '/config.php';

/**
 * Returns a shared PDO connection (lazy singleton).
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        respond_json(['success' => false, 'message' => 'Database connection failed.'], 500, $e);
    }
}

/**
 * Sends a JSON response and terminates the request.
 * $debug (an exception) is only surfaced when APP_ENV=development.
 */
function respond_json(array $payload, int $status = 200, ?Throwable $debug = null): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: ' . ALLOWED_ORIGIN);
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');

    if ($debug && APP_ENV === 'development') {
        $payload['debug'] = $debug->getMessage();
    }

    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * Trims, strips tags, and caps length on a raw string field.
 */
function clean_str(?string $value, int $maxLen = 2000): string
{
    $value = trim((string) $value);
    $value = strip_tags($value);
    return mb_substr($value, 0, $maxLen);
}

function is_valid_email(string $email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Extremely lightweight per-IP rate limit for public POST endpoints,
 * backed by the filesystem so it needs no extra infrastructure.
 * Allows $limit submissions per $windowSeconds.
 */
function rate_limit_ok(string $bucket, int $limit = 5, int $windowSeconds = 3600): bool
{
    $ip  = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $dir = sys_get_temp_dir() . '/foak_rate';
    if (!is_dir($dir)) {
        mkdir($dir, 0700, true);
    }
    $file = $dir . '/' . $bucket . '_' . md5($ip) . '.json';

    $now = time();
    $hits = [];
    if (is_file($file)) {
        $hits = json_decode((string) file_get_contents($file), true) ?: [];
    }
    // keep only hits inside the current window
    $hits = array_values(array_filter($hits, fn($t) => $t > $now - $windowSeconds));

    if (count($hits) >= $limit) {
        return false;
    }

    $hits[] = $now;
    file_put_contents($file, json_encode($hits));
    return true;
}

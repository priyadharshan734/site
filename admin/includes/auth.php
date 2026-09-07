<?php
/**
 * auth.php
 * Include at the very top of every protected admin page, before any output.
 * Starts (or resumes) a hardened session and redirects to login if the
 * visitor isn't an authenticated admin.
 */

require_once __DIR__ . '/../../php/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Idle timeout — 45 minutes of inactivity signs the admin out automatically.
$idleLimit = 45 * 60;
if (!empty($_SESSION['admin_id']) && !empty($_SESSION['last_activity'])
    && (time() - $_SESSION['last_activity']) > $idleLimit) {
    session_unset();
    session_destroy();
}

function admin_is_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function require_admin(): void
{
    if (!admin_is_logged_in()) {
        $redirect = urlencode($_SERVER['REQUEST_URI'] ?? 'dashboard.php');
        header('Location: login.php?redirect=' . $redirect);
        exit;
    }
    $_SESSION['last_activity'] = time();
}

/** Generates (or reuses) a CSRF token for the current session. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/** Validates a submitted CSRF token using a timing-safe comparison. */
function csrf_check(?string $submitted): bool
{
    return is_string($submitted) && !empty($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $submitted);
}

<?php
/**
 * create_admin_cli.php
 * Run from the command line ONLY — never expose this over HTTP.
 *
 * Usage:
 *   php php/create_admin_cli.php "Jane Doe" jane@forthrightandoak.com
 *
 * You'll be prompted for a password (hidden where the terminal supports it).
 * The password is hashed with password_hash() before it ever touches the
 * database — the plaintext is never stored or logged.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This script can only be run from the command line.');
}

require_once __DIR__ . '/functions.php';

$name  = $argv[1] ?? null;
$email = $argv[2] ?? null;

if (!$name || !$email || !is_valid_email($email)) {
    fwrite(STDERR, "Usage: php create_admin_cli.php \"Full Name\" email@example.com\n");
    exit(1);
}

fwrite(STDOUT, "Password: ");
// Attempt to hide input on Unix-like terminals; falls back to visible input on Windows.
$isUnix = stripos(PHP_OS, 'WIN') === false;
if ($isUnix) {
    shell_exec('stty -echo');
}
$password = trim((string) fgets(STDIN));
if ($isUnix) {
    shell_exec('stty echo');
    fwrite(STDOUT, "\n");
}

if (strlen($password) < 10) {
    fwrite(STDERR, "Password must be at least 10 characters.\n");
    exit(1);
}

$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = db()->prepare(
        'INSERT INTO admin_users (name, email, password_hash)
         VALUES (:name, :email, :hash)
         ON DUPLICATE KEY UPDATE name = VALUES(name), password_hash = VALUES(password_hash)'
    );
    $stmt->execute([
        ':name'  => clean_str($name, 120),
        ':email' => strtolower(clean_str($email, 190)),
        ':hash'  => $hash,
    ]);
    fwrite(STDOUT, "Admin user saved for {$email}.\n");
} catch (Throwable $e) {
    fwrite(STDERR, "Failed: " . $e->getMessage() . "\n");
    exit(1);
}

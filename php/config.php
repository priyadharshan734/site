<?php
/**
 * config.php
 * Central configuration. In production, pull these from environment
 * variables rather than committing real credentials to source control.
 */

// ---- Database ----
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_NAME', getenv('DB_NAME') ?: 'forthright_oak');
define('DB_USER', getenv('DB_USER') ?: 'forthright_app');
define('DB_PASS', getenv('DB_PASS') ?: 'change-me');
define('DB_CHARSET', 'utf8mb4');

// ---- Mail (used by contact_handler.php) ----
define('COMPANY_NOTIFY_EMAIL', getenv('COMPANY_NOTIFY_EMAIL') ?: 'projects@forthrightandoak.com');
define('COMPANY_NAME', 'Forthright & Oak');

// ---- App ----
define('APP_ENV', getenv('APP_ENV') ?: 'production'); // 'development' surfaces full error detail
define('ALLOWED_ORIGIN', getenv('ALLOWED_ORIGIN') ?: '*'); // lock this down to your real domain in production

error_reporting(APP_ENV === 'development' ? E_ALL : 0);
ini_set('display_errors', APP_ENV === 'development' ? '1' : '0');

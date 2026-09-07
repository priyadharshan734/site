<?php
/**
 * contact_handler.php
 * POST /php/contact_handler.php
 * Body (JSON or form-encoded): { name, email, phone, service, message }
 *
 * Validates and stores an inbound lead, then emails the team a notice.
 * Responds with { success: bool, message: string }.
 */

require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    respond_json(['success' => true]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

if (!rate_limit_ok('contact', 5, 3600)) {
    respond_json(['success' => false, 'message' => 'Too many submissions. Please try again later or call us directly.'], 429);
}

// Accept both JSON bodies (fetch) and classic form posts, for resilience.
$raw = file_get_contents('php://input');
$json = json_decode($raw, true);
$input = is_array($json) ? $json : $_POST;

$name    = clean_str($input['name'] ?? '', 120);
$email   = clean_str($input['email'] ?? '', 190);
$phone   = clean_str($input['phone'] ?? '', 40);
$service = clean_str($input['service'] ?? '', 60);
$message = clean_str($input['message'] ?? '', 4000);

// Honeypot field — real users never fill this in; bots often do.
if (!empty($input['website'])) {
    respond_json(['success' => true, 'message' => 'Message sent.']); // silently accept, do nothing
}

$errors = [];
if (mb_strlen($name) < 2)               $errors[] = 'Please enter your name.';
if (!is_valid_email($email))            $errors[] = 'Please enter a valid email address.';
if (mb_strlen(preg_replace('/\D/', '', $phone)) < 7) $errors[] = 'Please enter a valid phone number.';
if (mb_strlen($message) < 10)           $errors[] = 'Please tell us a bit more about your project.';

if ($errors) {
    respond_json(['success' => false, 'message' => implode(' ', $errors)], 422);
}

try {
    $stmt = db()->prepare(
        'INSERT INTO messages (name, email, phone, service, message, ip_address)
         VALUES (:name, :email, :phone, :service, :message, :ip)'
    );
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':phone'   => $phone,
        ':service' => $service ?: null,
        ':message' => $message,
        ':ip'      => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    notify_team($name, $email, $phone, $service, $message);

    respond_json([
        'success' => true,
        'message' => "Message sent — we'll be in touch within one business day."
    ]);
} catch (Throwable $e) {
    respond_json(['success' => false, 'message' => 'We could not save your message. Please try again.'], 500, $e);
}

/**
 * Best-effort notification email. Failure to send never blocks the
 * successful save of the lead — the database row is the source of truth.
 */
function notify_team(string $name, string $email, string $phone, string $service, string $message): void
{
    $to      = COMPANY_NOTIFY_EMAIL;
    $subject = '[' . COMPANY_NAME . '] New project inquiry from ' . $name;
    $body    = "New inquiry received via the website contact form:\n\n"
             . "Name:    {$name}\n"
             . "Email:   {$email}\n"
             . "Phone:   {$phone}\n"
             . "Service: " . ($service ?: 'Not specified') . "\n\n"
             . "Message:\n{$message}\n";

    $headers = "From: no-reply@forthrightandoak.com\r\nReply-To: {$email}\r\n";

    // mail() requires a configured MTA on the server; swap for a transactional
    // email API (SendGrid, Postmark, SES) in production for reliable delivery.
    if (function_exists('mail')) {
        @mail($to, $subject, $body, $headers);
    }
}

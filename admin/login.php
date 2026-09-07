<?php
require_once __DIR__ . '/includes/auth.php';

if (admin_is_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired — please try again.';
    } elseif (!rate_limit_ok('admin_login', 8, 900)) {
        $error = 'Too many attempts. Please wait a few minutes and try again.';
    } else {
        $email    = strtolower(clean_str($_POST['email'] ?? '', 190));
        $password = (string) ($_POST['password'] ?? '');

        try {
            $stmt = db()->prepare('SELECT id, name, password_hash FROM admin_users WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id']   = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['last_activity'] = time();

                db()->prepare('UPDATE admin_users SET last_login_at = NOW() WHERE id = :id')
                    ->execute([':id' => $admin['id']]);

                $redirect = $_GET['redirect'] ?? 'dashboard.php';
                // Only allow internal redirects — never send the browser to an external host.
                $redirect = (strpos($redirect, '//') === false && strpos($redirect, ':') === false) ? $redirect : 'dashboard.php';
                header('Location: ' . $redirect);
                exit;
            }
            $error = 'Incorrect email or password.';
        } catch (Throwable $e) {
            $error = 'Something went wrong. Please try again.';
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login — Forthright &amp; Oak</title>
<meta name="robots" content="noindex, nofollow">
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-body">

<div class="login-wrap">
  <div class="login-card">
    <a href="../index.php" class="brand" style="text-decoration:none;">Forthright <small>&amp; Oak</small></a>
    <span class="spec-label">Staff Access</span>
    <h1 style="font-size:1.6rem; margin-bottom:1.4rem;">Admin Sign In</h1>

    <?php if ($error): ?>
      <p class="form-status err" style="margin-bottom:1.2rem;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" novalidate>
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
      <div class="field">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required autocomplete="username" autofocus>
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
      </div>
      <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Sign In</button>
    </form>
  </div>
</div>

</body>
</html>

<?php
/**
 * admin-header.php
 * Expects require_admin() already called, and $active_admin set by the page.
 */
$active_admin = $active_admin ?? '';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($admin_page_title ?? 'Admin — Forthright & Oak') ?></title>
<meta name="robots" content="noindex, nofollow">
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/admin.css">
</head>
<body class="admin-body">

<div class="admin-topbar">
  <a href="dashboard.php" class="brand">Forthright <small>&amp; Oak</small> · Admin</a>
  <nav>
    <a href="dashboard.php" class="<?= $active_admin === 'dashboard' ? 'is-active' : '' ?>">Dashboard</a>
    <a href="messages.php" class="<?= $active_admin === 'messages' ? 'is-active' : '' ?>">Messages</a>
    <a href="projects.php" class="<?= $active_admin === 'projects' ? 'is-active' : '' ?>">Projects</a>
    <a href="testimonials.php" class="<?= $active_admin === 'testimonials' ? 'is-active' : '' ?>">Testimonials</a>
    <span style="color:rgba(237,234,226,0.5);">|</span>
    <span style="font-family:var(--font-mono); font-size:0.78rem;">Hi, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
    <a href="logout.php" class="logout">Sign Out</a>
  </nav>
</div>

<div class="admin-shell">

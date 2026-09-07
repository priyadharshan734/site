<?php
/**
 * header.php
 * Included by every top-level page. Expects the including page to define:
 *   $base        — relative path prefix back to site root ('' or '../')
 *   $page_title  — <title> text
 *   $page_desc   — meta description
 *   $active      — nav key: 'home' | 'home-building' | 'interior-design' | 'exterior-work' | 'contact'
 */
$base       = $base ?? '';
$page_title = $page_title ?? 'Forthright & Oak — Construction & Interior Design';
$page_desc  = $page_desc ?? 'Forthright & Oak builds homes, designs interiors, and shapes outdoor living spaces with honest craftsmanship.';
$active     = $active ?? '';
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title) ?></title>
<meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@600;700;800&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600;1,8..60,400&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= $base ?>css/style.css">
<link rel="stylesheet" href="<?= $base ?>css/animations.css">
</head>
<body>

<header class="site-header">
  <nav class="nav">
    <a href="<?= $base ?>index.php" class="brand">Forthright <small>&amp; Oak</small></a>

    <ul class="nav-links">
      <li><a href="<?= $base ?>index.php" <?= $active === 'home' ? 'aria-current="page"' : '' ?>>Home</a></li>
      <li><a href="<?= $base ?>services/home-building.php" <?= $active === 'home-building' ? 'aria-current="page"' : '' ?>>Home Building</a></li>
      <li><a href="<?= $base ?>services/interior-design.php" <?= $active === 'interior-design' ? 'aria-current="page"' : '' ?>>Interior Design</a></li>
      <li><a href="<?= $base ?>services/exterior-work.php" <?= $active === 'exterior-work' ? 'aria-current="page"' : '' ?>>Exterior Work</a></li>
      <li><a href="<?= $base ?>contact.php" <?= $active === 'contact' ? 'aria-current="page"' : '' ?>>Contact</a></li>
    </ul>

    <div class="nav-cta">
      <a href="tel:+18135550142" class="btn btn-ghost" style="border-color:var(--line);">
        <span class="btn-text-full">(813) 555‑0142</span>
      </a>
      <a href="<?= $base ?>contact.php" class="btn btn-primary">Get a Quote</a>
      <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
</header>

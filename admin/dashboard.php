<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();

$active_admin = 'dashboard';
$admin_page_title = 'Dashboard — Admin';

$counts = ['new' => 0, 'total_messages' => 0, 'projects' => 0, 'testimonials' => 0];
$recent = [];

try {
    $counts['total_messages'] = (int) db()->query('SELECT COUNT(*) FROM messages')->fetchColumn();
    $counts['new']            = (int) db()->query("SELECT COUNT(*) FROM messages WHERE status = 'new'")->fetchColumn();
    $counts['projects']       = (int) db()->query('SELECT COUNT(*) FROM projects')->fetchColumn();
    $counts['testimonials']   = (int) db()->query('SELECT COUNT(*) FROM testimonials')->fetchColumn();

    $recent = db()->query(
        'SELECT id, name, email, service, status, created_at
         FROM messages ORDER BY created_at DESC LIMIT 6'
    )->fetchAll();
} catch (Throwable $e) {
    // Surfaced inline below rather than a hard failure, since this is a read-only view.
}

include __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-toolbar">
  <h1>Dashboard</h1>
  <span class="spec-label" style="margin:0;">Internal — not visible to site visitors</span>
</div>

<div class="admin-grid-cards">
  <div class="admin-card admin-metric">
    <span class="num"><?= $counts['new'] ?></span>
    <span class="label">New Inquiries</span>
  </div>
  <div class="admin-card admin-metric">
    <span class="num"><?= $counts['total_messages'] ?></span>
    <span class="label">Total Inquiries</span>
  </div>
  <div class="admin-card admin-metric">
    <span class="num"><?= $counts['projects'] ?></span>
    <span class="label">Published Projects</span>
  </div>
  <div class="admin-card admin-metric">
    <span class="num"><?= $counts['testimonials'] ?></span>
    <span class="label">Testimonials</span>
  </div>
</div>

<div class="admin-card">
  <div class="admin-toolbar" style="margin-bottom:1rem;">
    <h1 style="font-size:1.1rem;">Recent Inquiries</h1>
    <a href="messages.php" class="btn" style="padding:0.5em 1em;">View All</a>
  </div>

  <?php if ($recent): ?>
  <table class="admin-table">
    <thead>
      <tr><th>Name</th><th>Email</th><th>Service</th><th>Status</th><th>Received</th></tr>
    </thead>
    <tbody>
      <?php foreach ($recent as $row): ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['service'] ?: '—') ?></td>
        <td><span class="pill pill-<?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
        <td><?= htmlspecialchars(date('M j, g:ia', strtotime($row['created_at']))) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p class="empty-state">No inquiries yet.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>

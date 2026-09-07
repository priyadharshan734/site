<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();

$active_admin = 'messages';
$admin_page_title = 'Messages — Admin';
$notice = '';

// ---- Handle status update / delete actions ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? null)) {
        $notice = 'Your session expired — please retry that action.';
    } else {
        $id     = (int) ($_POST['id'] ?? 0);
        $action = $_POST['action'] ?? '';

        try {
            if ($action === 'update_status' && in_array($_POST['status'] ?? '', ['new', 'contacted', 'archived'], true)) {
                $stmt = db()->prepare('UPDATE messages SET status = :status WHERE id = :id');
                $stmt->execute([':status' => $_POST['status'], ':id' => $id]);
                $notice = 'Status updated.';
            } elseif ($action === 'delete') {
                $stmt = db()->prepare('DELETE FROM messages WHERE id = :id');
                $stmt->execute([':id' => $id]);
                $notice = 'Message deleted.';
            }
        } catch (Throwable $e) {
            $notice = 'Could not complete that action.';
        }
    }
}

// ---- Optional filter ----
$statusFilter = $_GET['status'] ?? 'all';
$validStatuses = ['all', 'new', 'contacted', 'archived'];
if (!in_array($statusFilter, $validStatuses, true)) $statusFilter = 'all';

$messages = [];
try {
    if ($statusFilter === 'all') {
        $messages = db()->query('SELECT * FROM messages ORDER BY created_at DESC')->fetchAll();
    } else {
        $stmt = db()->prepare('SELECT * FROM messages WHERE status = :status ORDER BY created_at DESC');
        $stmt->execute([':status' => $statusFilter]);
        $messages = $stmt->fetchAll();
    }
} catch (Throwable $e) {
    $notice = 'Could not load messages.';
}

include __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-toolbar">
  <h1>Messages</h1>
  <div style="display:flex; gap:0.5rem;">
    <?php foreach ($validStatuses as $s): ?>
      <a href="?status=<?= $s ?>" class="btn" style="padding:0.5em 1em; <?= $s === $statusFilter ? 'background:var(--ink); color:var(--paper);' : '' ?>"><?= ucfirst($s) ?></a>
    <?php endforeach; ?>
  </div>
</div>

<?php if ($notice): ?><p class="form-status ok" style="margin-bottom:1rem;"><?= htmlspecialchars($notice) ?></p><?php endif; ?>

<div class="admin-card">
  <?php if ($messages): ?>
  <table class="admin-table">
    <thead>
      <tr><th>Name</th><th>Contact</th><th>Service</th><th>Message</th><th>Status</th><th>Received</th><th>Actions</th></tr>
    </thead>
    <tbody>
      <?php foreach ($messages as $m): ?>
      <tr>
        <td><?= htmlspecialchars($m['name']) ?></td>
        <td>
          <a href="mailto:<?= htmlspecialchars($m['email']) ?>"><?= htmlspecialchars($m['email']) ?></a><br>
          <span style="color:var(--concrete-2); font-size:0.85rem;"><?= htmlspecialchars($m['phone']) ?></span>
        </td>
        <td><?= htmlspecialchars($m['service'] ?: '—') ?></td>
        <td style="max-width:280px;"><?= nl2br(htmlspecialchars(mb_strimwidth($m['message'], 0, 220, '…'))) ?></td>
        <td>
          <form method="post" style="display:flex; gap:0.4rem; align-items:center;">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
            <input type="hidden" name="action" value="update_status">
            <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
            <select name="status" class="status-select" onchange="this.form.submit()">
              <?php foreach (['new','contacted','archived'] as $opt): ?>
                <option value="<?= $opt ?>" <?= $m['status'] === $opt ? 'selected' : '' ?>><?= ucfirst($opt) ?></option>
              <?php endforeach; ?>
            </select>
          </form>
        </td>
        <td><?= htmlspecialchars(date('M j, Y g:ia', strtotime($m['created_at']))) ?></td>
        <td>
          <form method="post" onsubmit="return confirm('Delete this message permanently?');">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
            <button type="submit" class="icon-btn">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p class="empty-state">No messages in this view.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>

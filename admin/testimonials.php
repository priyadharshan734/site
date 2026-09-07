<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();

$active_admin = 'testimonials';
$admin_page_title = 'Testimonials — Admin';
$notice = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? null)) {
        $notice = 'Your session expired — please retry.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'delete') {
            db()->prepare('DELETE FROM testimonials WHERE id = :id')->execute([':id' => (int) $_POST['id']]);
            $notice = 'Testimonial deleted.';
        }

        if ($action === 'toggle_publish') {
            db()->prepare('UPDATE testimonials SET is_published = 1 - is_published WHERE id = :id')
                ->execute([':id' => (int) $_POST['id']]);
            $notice = 'Publish status updated.';
        }

        if ($action === 'create') {
            $client = clean_str($_POST['client_name'] ?? '', 120);
            $quote  = clean_str($_POST['quote'] ?? '', 1000);
            $rating = max(1, min(5, (int) ($_POST['rating'] ?? 5)));

            if (mb_strlen($client) < 2) $errors[] = 'Client name is required.';
            if (mb_strlen($quote) < 10) $errors[] = 'Quote is too short.';

            if (!$errors) {
                db()->prepare('INSERT INTO testimonials (client_name, quote, rating) VALUES (:c, :q, :r)')
                    ->execute([':c' => $client, ':q' => $quote, ':r' => $rating]);
                $notice = 'Testimonial added.';
            }
        }
    }
}

$testimonials = db()->query('SELECT * FROM testimonials ORDER BY created_at DESC')->fetchAll();

include __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-toolbar"><h1>Testimonials</h1></div>

<?php if ($notice): ?><p class="form-status ok" style="margin-bottom:1rem;"><?= htmlspecialchars($notice) ?></p><?php endif; ?>
<?php if ($errors): ?><p class="form-status err" style="margin-bottom:1rem;"><?= htmlspecialchars(implode(' ', $errors)) ?></p><?php endif; ?>

<div class="admin-card" style="margin-bottom:2rem;">
  <h3 style="margin-top:0;">Add a Testimonial</h3>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
    <input type="hidden" name="action" value="create">
    <div class="form-row">
      <div class="field"><label>Client Name</label><input type="text" name="client_name" required></div>
      <div class="field"><label>Rating (1–5)</label><input type="number" name="rating" min="1" max="5" value="5"></div>
    </div>
    <div class="field"><label>Quote</label><textarea name="quote" required></textarea></div>
    <button type="submit" class="btn btn-primary">Add Testimonial</button>
  </form>
</div>

<div class="admin-card">
  <?php if ($testimonials): ?>
  <table class="admin-table">
    <thead><tr><th>Client</th><th>Quote</th><th>Rating</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($testimonials as $t): ?>
      <tr>
        <td><?= htmlspecialchars($t['client_name']) ?></td>
        <td style="max-width:360px;"><?= htmlspecialchars(mb_strimwidth($t['quote'], 0, 160, '…')) ?></td>
        <td><?= str_repeat('★', (int) $t['rating']) ?></td>
        <td><span class="pill <?= $t['is_published'] ? 'pill-contacted' : 'pill-archived' ?>"><?= $t['is_published'] ? 'Published' : 'Hidden' ?></span></td>
        <td style="display:flex; gap:0.8rem;">
          <form method="post">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
            <input type="hidden" name="action" value="toggle_publish">
            <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">
            <button type="submit" class="icon-btn" style="color:var(--blueprint);"><?= $t['is_published'] ? 'Hide' : 'Publish' ?></button>
          </form>
          <form method="post" onsubmit="return confirm('Delete this testimonial?');">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int) $t['id'] ?>">
            <button type="submit" class="icon-btn">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p class="empty-state">No testimonials yet.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>

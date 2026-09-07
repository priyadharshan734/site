<?php
require_once __DIR__ . '/includes/auth.php';
require_admin();

$active_admin = 'projects';
$admin_page_title = 'Projects — Admin';
$notice = '';
$errors = [];

$categories = ['home-building', 'interior-design', 'exterior-work'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_check($_POST['csrf_token'] ?? null)) {
        $notice = 'Your session expired — please retry.';
    } else {
        $action = $_POST['action'] ?? '';

        if ($action === 'delete') {
            try {
                db()->prepare('DELETE FROM projects WHERE id = :id')->execute([':id' => (int) $_POST['id']]);
                $notice = 'Project deleted.';
            } catch (Throwable $e) {
                $notice = 'Could not delete that project.';
            }
        }

        if ($action === 'create') {
            $title       = clean_str($_POST['title'] ?? '', 150);
            $category    = $_POST['category'] ?? '';
            $location    = clean_str($_POST['location'] ?? '', 120);
            $description = clean_str($_POST['description'] ?? '', 2000);
            $image_url   = clean_str($_POST['image_url'] ?? '', 500);
            $sq_ft       = $_POST['sq_ft'] !== '' ? (int) $_POST['sq_ft'] : null;
            $completed   = $_POST['completed_on'] !== '' ? $_POST['completed_on'] : null;
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;

            if (mb_strlen($title) < 2) $errors[] = 'Title is required.';
            if (!in_array($category, $categories, true)) $errors[] = 'Choose a valid category.';
            if (!filter_var($image_url, FILTER_VALIDATE_URL)) $errors[] = 'Image URL must be a valid URL.';

            if (!$errors) {
                try {
                    $stmt = db()->prepare(
                        'INSERT INTO projects (title, category, location, description, image_url, sq_ft, completed_on, is_featured)
                         VALUES (:title, :category, :location, :description, :image_url, :sq_ft, :completed_on, :is_featured)'
                    );
                    $stmt->execute([
                        ':title' => $title, ':category' => $category, ':location' => $location,
                        ':description' => $description, ':image_url' => $image_url,
                        ':sq_ft' => $sq_ft, ':completed_on' => $completed, ':is_featured' => $is_featured,
                    ]);
                    $notice = 'Project added — it will appear in the public gallery immediately.';
                } catch (Throwable $e) {
                    $errors[] = 'Could not save that project.';
                }
            }
        }
    }
}

$projects = [];
try {
    $projects = db()->query('SELECT * FROM projects ORDER BY display_order ASC, created_at DESC')->fetchAll();
} catch (Throwable $e) {
    $notice = 'Could not load projects.';
}

include __DIR__ . '/includes/admin-header.php';
?>

<div class="admin-toolbar"><h1>Projects</h1></div>

<?php if ($notice): ?><p class="form-status ok" style="margin-bottom:1rem;"><?= htmlspecialchars($notice) ?></p><?php endif; ?>
<?php if ($errors): ?><p class="form-status err" style="margin-bottom:1rem;"><?= htmlspecialchars(implode(' ', $errors)) ?></p><?php endif; ?>

<div class="admin-card" style="margin-bottom:2rem;">
  <h3 style="margin-top:0;">Add a Project</h3>
  <form method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
    <input type="hidden" name="action" value="create">
    <div class="form-row">
      <div class="field"><label>Title</label><input type="text" name="title" required></div>
      <div class="field">
        <label>Category</label>
        <select name="category" required>
          <?php foreach ($categories as $c): ?><option value="<?= $c ?>"><?= ucwords(str_replace('-', ' ', $c)) ?></option><?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="field"><label>Location</label><input type="text" name="location" placeholder="City, State"></div>
      <div class="field"><label>Sq Ft</label><input type="number" name="sq_ft" min="0"></div>
    </div>
    <div class="form-row">
      <div class="field"><label>Image URL</label><input type="url" name="image_url" required placeholder="https://…"></div>
      <div class="field"><label>Completed On</label><input type="date" name="completed_on"></div>
    </div>
    <div class="field"><label>Description</label><textarea name="description"></textarea></div>
    <div class="field">
      <label><input type="checkbox" name="is_featured" style="width:auto; display:inline-block; margin-right:0.5em;">Feature on homepage</label>
    </div>
    <button type="submit" class="btn btn-primary">Add Project</button>
  </form>
</div>

<div class="admin-card">
  <?php if ($projects): ?>
  <table class="admin-table">
    <thead><tr><th>Title</th><th>Category</th><th>Location</th><th>Featured</th><th>Completed</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($projects as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['title']) ?></td>
        <td><?= htmlspecialchars(ucwords(str_replace('-', ' ', $p['category']))) ?></td>
        <td><?= htmlspecialchars($p['location']) ?></td>
        <td><?= $p['is_featured'] ? '<span class="pill pill-contacted">Featured</span>' : '—' ?></td>
        <td><?= $p['completed_on'] ? htmlspecialchars(date('M Y', strtotime($p['completed_on']))) : '—' ?></td>
        <td>
          <form method="post" onsubmit="return confirm('Remove this project from the public site?');">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token()) ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int) $p['id'] ?>">
            <button type="submit" class="icon-btn">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php else: ?>
    <p class="empty-state">No projects yet — add your first one above.</p>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>

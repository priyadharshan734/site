<?php
/**
 * get_projects.php
 * GET /php/get_projects.php
 * GET /php/get_projects.php?category=interior-design
 * GET /php/get_projects.php?featured=1&limit=3
 *
 * Returns a JSON array of completed projects for the homepage gallery
 * and service pages. Read-only, no auth required.
 */

require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    respond_json(['success' => true]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respond_json(['success' => false, 'message' => 'Method not allowed.'], 405);
}

$validCategories = ['home-building', 'interior-design', 'exterior-work'];
$category = $_GET['category'] ?? null;
$featuredOnly = isset($_GET['featured']) && $_GET['featured'] === '1';
$limit = isset($_GET['limit']) ? max(1, min(24, (int) $_GET['limit'])) : 24;

if ($category !== null && !in_array($category, $validCategories, true)) {
    respond_json(['success' => false, 'message' => 'Unknown category.'], 400);
}

try {
    $sql = 'SELECT id, title, category, location, description, image_url AS image,
                   sq_ft, completed_on, is_featured
            FROM projects
            WHERE 1=1';
    $params = [];

    if ($category !== null) {
        $sql .= ' AND category = :category';
        $params[':category'] = $category;
    }
    if ($featuredOnly) {
        $sql .= ' AND is_featured = 1';
    }

    $sql .= ' ORDER BY display_order ASC, completed_on DESC LIMIT :limit';

    $stmt = db()->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    $projects = $stmt->fetchAll();

    respond_json_raw($projects);
} catch (Throwable $e) {
    respond_json(['success' => false, 'message' => 'Could not load projects.'], 500, $e);
}

/**
 * The gallery front-end expects a bare JSON array (not wrapped in an
 * envelope), matching the shape of the static fallback data in main.js.
 */
function respond_json_raw(array $data): void
{
    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: ' . ALLOWED_ORIGIN);
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
    exit;
}

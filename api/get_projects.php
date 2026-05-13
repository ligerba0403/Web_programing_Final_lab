<?php
/**
 * GET /api/get_projects.php
 * Returns all projects as JSON.
 * ?category=Web  — filter by category
 * ?lang=en       — return title_en/description_en as title/description
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

require_once __DIR__ . '/../includes/db.php';

try {
    $pdo      = getPDO();
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    $lang     = isset($_GET['lang']) && $_GET['lang'] === 'en' ? 'en' : 'tr';

    $sql = 'SELECT id, title, title_en, description, description_en,
                   image_url, technologies, category, project_url, github_url, is_featured
            FROM projects';

    if ($category && $category !== 'all') {
        $stmt = $pdo->prepare($sql . ' WHERE category = :cat ORDER BY sort_order ASC, created_at DESC');
        $stmt->execute([':cat' => $category]);
    } else {
        $stmt = $pdo->query($sql . ' ORDER BY sort_order ASC, created_at DESC');
    }

    $rows = $stmt->fetchAll();

    // Resolve language: use EN fields when lang=en and EN content exists
    $projects = array_map(function($p) use ($lang) {
        if ($lang === 'en') {
            $p['title']       = !empty($p['title_en'])       ? $p['title_en']       : $p['title'];
            $p['description'] = !empty($p['description_en']) ? $p['description_en'] : $p['description'];
        }
        unset($p['title_en'], $p['description_en']);
        return $p;
    }, $rows);

    echo json_encode(['success' => true, 'projects' => $projects]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error.']);
}

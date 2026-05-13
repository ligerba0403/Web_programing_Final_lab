<?php
/**
 * Admin — Delete Project (POST only)
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id) {
    $pdo  = getPDO();
    $stmt = $pdo->prepare('DELETE FROM projects WHERE id = ?');
    $stmt->execute([$id]);
    $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Proje silindi.'];
} else {
    $_SESSION['flash'] = ['type' => 'error', 'msg' => 'Geçersiz proje ID.'];
}

header('Location: dashboard.php');
exit;

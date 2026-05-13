<?php
/**
 * Admin — Add New Project
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$errors = [];
$data   = ['title'=>'','title_en'=>'','description'=>'','description_en'=>'','image_url'=>'','technologies'=>'','category'=>'Web','project_url'=>'','github_url'=>'','is_featured'=>0,'sort_order'=>0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data['title']          = trim($_POST['title']          ?? '');
    $data['title_en']       = trim($_POST['title_en']       ?? '');
    $data['description']    = trim($_POST['description']    ?? '');
    $data['description_en'] = trim($_POST['description_en'] ?? '');
    $data['image_url']      = trim($_POST['image_url']      ?? '');
    $data['technologies']   = trim($_POST['technologies']   ?? '');
    $data['category']       = trim($_POST['category']       ?? 'Web');
    $data['project_url']    = trim($_POST['project_url']    ?? '');
    $data['github_url']     = trim($_POST['github_url']     ?? '');
    $data['is_featured']    = isset($_POST['is_featured']) ? 1 : 0;
    $data['sort_order']     = (int)($_POST['sort_order']    ?? 0);

    if (strlen($data['title']) < 2)        $errors[] = 'Başlık (TR) en az 2 karakter olmalı.';
    if (strlen($data['description']) < 10) $errors[] = 'Açıklama (TR) en az 10 karakter olmalı.';
    if (strlen($data['technologies']) < 1) $errors[] = 'En az bir teknoloji girin.';

    if (empty($errors)) {
        $pdo  = getPDO();
        $stmt = $pdo->prepare(
            'INSERT INTO projects (title, title_en, description, description_en, image_url, technologies, category, project_url, github_url, is_featured, sort_order)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['title'], $data['title_en'],
            $data['description'], $data['description_en'],
            $data['image_url'] ?: 'assets/images/project-placeholder.png',
            $data['technologies'], $data['category'],
            $data['project_url'] ?: null, $data['github_url'] ?: null,
            $data['is_featured'], $data['sort_order']
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'msg' => 'Proje başarıyla eklendi.'];
        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="tr" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Proje Ekle | Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar__logo">&lt;Admin/&gt;</div>
    <nav class="sidebar__nav">
      <a href="dashboard.php" class="sidebar__link">
        <i data-lucide="layout-dashboard"></i> <span data-admin-i18n="dashboard">Dashboard</span>
      </a>
      <a href="add_project.php" class="sidebar__link active">
        <i data-lucide="plus-circle"></i> <span data-admin-i18n="add_project">Proje Ekle</span>
      </a>
      <a href="#" class="sidebar__link" id="viewSiteBtn">
        <i data-lucide="globe"></i> <span data-admin-i18n="view_site">Siteyi Gör</span>
      </a>
      <a href="logout.php" class="sidebar__link sidebar__link--danger">
        <i data-lucide="log-out"></i> <span data-admin-i18n="logout">Çıkış</span>
      </a>
    </nav>
  </aside>

  <main class="admin-main">
    <header class="admin-header">
      <h1 data-admin-i18n="add_title">Yeni Proje Ekle</h1>
      <div class="admin-lang-toggle">
        <button class="admin-lang-btn active" data-lang="tr">TR</button>
        <button class="admin-lang-btn" data-lang="en">EN</button>
      </div>
    </header>

    <?php if ($errors): ?>
      <div class="alert alert--error"><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
    <?php endif; ?>

    <div class="form-card">
      <form method="POST" action="">
        <?php include __DIR__ . '/partials/project_form.php'; ?>
        <div class="form-actions">
          <a href="dashboard.php" class="btn btn--outline">
            <i data-lucide="arrow-left"></i> İptal
          </a>
          <button type="submit" class="btn btn--primary">
            <i data-lucide="save"></i> Kaydet
          </button>
        </div>
      </form>
    </div>
  </main>
  <script src="assets/js/admin.js"></script>
  <script>lucide.createIcons();</script>
</body>
</html>

<?php
/**
 * Admin Dashboard — Project list + message count
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$pdo = getPDO();

// Stats
$projectCount = (int)$pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn();
$messageCount = (int)$pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
$unreadCount  = (int)$pdo->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn();

// Projects list
$projects = $pdo->query(
    'SELECT id, title, category, technologies, is_featured, sort_order, created_at FROM projects ORDER BY sort_order ASC, created_at DESC'
)->fetchAll();

// Messages list (latest 10)
$messages = $pdo->query(
    'SELECT id, name, email, subject, is_read, created_at FROM messages ORDER BY created_at DESC LIMIT 10'
)->fetchAll();

// Flash message
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$adminLang = 'tr'; // resolved client-side via JS
?>
<!DOCTYPE html>
<html lang="tr" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Admin</title>
  <link rel="stylesheet" href="assets/css/admin.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="sidebar__logo">&lt;Admin/&gt;</div>
    <nav class="sidebar__nav">
      <a href="dashboard.php" class="sidebar__link active">
        <i data-lucide="layout-dashboard"></i> <span data-admin-i18n="dashboard">Dashboard</span>
      </a>
      <a href="add_project.php" class="sidebar__link">
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

  <!-- Main -->
  <main class="admin-main">
    <header class="admin-header">
      <h1 data-admin-i18n="dashboard">Dashboard</h1>
      <div style="display:flex;align-items:center;gap:16px;">
        <div class="admin-lang-toggle">
          <button class="admin-lang-btn <?= $adminLang === 'tr' ? 'active' : '' ?>" data-lang="tr">TR</button>
          <button class="admin-lang-btn <?= $adminLang === 'en' ? 'active' : '' ?>" data-lang="en">EN</button>
        </div>
        <span class="admin-user"><i data-lucide="user-circle" style="width:16px;height:16px;vertical-align:middle;margin-right:4px;"></i><?= htmlspecialchars($_SESSION[SESSION_KEY]) ?></span>
      </div>
    </header>

    <?php if ($flash): ?>
      <div class="alert alert--<?= $flash['type'] ?>"><?= htmlspecialchars($flash['msg']) ?></div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <span class="stat-card__num"><?= $projectCount ?></span>
        <span class="stat-card__label">Toplam Proje</span>
      </div>
      <div class="stat-card">
        <span class="stat-card__num"><?= $messageCount ?></span>
        <span class="stat-card__label">Toplam Mesaj</span>
      </div>
      <div class="stat-card stat-card--accent">
        <span class="stat-card__num"><?= $unreadCount ?></span>
        <span class="stat-card__label">Okunmamış Mesaj</span>
      </div>
    </div>

    <!-- Projects Table -->
    <section class="admin-section">
      <div class="admin-section__header">
        <h2>Projeler</h2>
        <a href="add_project.php" class="btn btn--primary btn--sm">+ Yeni Proje</a>
      </div>
      <div class="table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Başlık</th>
              <th>Kategori</th>
              <th>Teknolojiler</th>
              <th>Öne Çıkan</th>
              <th>Tarih</th>
              <th>İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($projects)): ?>
              <tr><td colspan="7" class="text-center text-muted">Henüz proje yok.</td></tr>
            <?php else: ?>
              <?php foreach ($projects as $p): ?>
              <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['title']) ?></td>
                <td><span class="badge"><?= htmlspecialchars($p['category']) ?></span></td>
                <td class="text-mono text-sm"><?= htmlspecialchars($p['technologies']) ?></td>
                <td><?= $p['is_featured'] ? '<span class="badge badge--success"><i data-lucide="star" style="width:11px;height:11px;vertical-align:middle;"></i> Evet</span>' : '<span class="text-muted">—</span>' ?></td>
                <td class="text-sm text-muted"><?= date('d.m.Y', strtotime($p['created_at'])) ?></td>
                <td class="actions">
                  <a href="edit_project.php?id=<?= $p['id'] ?>" class="btn btn--sm btn--outline">Düzenle</a>
                  <form method="POST" action="delete_project.php" style="display:inline"
                        onsubmit="return confirm('Bu projeyi silmek istediğinize emin misiniz?')">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>" />
                    <button type="submit" class="btn btn--sm btn--danger">Sil</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Messages Table -->
    <section class="admin-section">
      <div class="admin-section__header">
        <h2>Son Mesajlar</h2>
      </div>
      <div class="table-wrap">
        <table class="admin-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Ad</th>
              <th>E-posta</th>
              <th>Konu</th>
              <th>Durum</th>
              <th>Tarih</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($messages)): ?>
              <tr><td colspan="6" class="text-center text-muted">Henüz mesaj yok.</td></tr>
            <?php else: ?>
              <?php foreach ($messages as $m): ?>
              <tr class="<?= $m['is_read'] ? '' : 'row--unread' ?>">
                <td><?= $m['id'] ?></td>
                <td><?= htmlspecialchars($m['name']) ?></td>
                <td class="text-sm"><?= htmlspecialchars($m['email']) ?></td>
                <td><?= htmlspecialchars($m['subject']) ?></td>
                <td><?= $m['is_read'] ? '<span class="badge badge--success">Okundu</span>' : '<span class="badge badge--warn">Yeni</span>' ?></td>
                <td class="text-sm text-muted"><?= date('d.m.Y H:i', strtotime($m['created_at'])) ?></td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </section>

  </main>

  <script src="assets/js/admin.js"></script>
  <script>lucide.createIcons();</script>
</body>
</html>

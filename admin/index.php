<?php
/**
 * Admin Login Page
 */
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

// Already logged in → redirect
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $pdo  = getPDO();
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION[SESSION_KEY] = $user['username'];

            // Remember me cookie (7 days)
            if (!empty($_POST['remember'])) {
                setcookie(COOKIE_NAME, $user['username'], time() + COOKIE_TTL, '/', '', false, true);
            }

            header('Location: dashboard.php');
            exit;
        }
    }
    $error = 'Kullanıcı adı veya şifre hatalı.';
}
?>
<!DOCTYPE html>
<html lang="tr" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Giriş | Portfolio</title>
  <link rel="stylesheet" href="assets/css/admin.css" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
</head>
<body class="login-page">
  <div class="login-card">
    <div class="login-card__header">
      <span class="login-logo">&lt;Admin/&gt;</span>
      <h1>Giriş Yap</h1>
      <p>Portfolio yönetim paneli</p>
    </div>

    <?php if ($error): ?>
      <div class="alert alert--error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="" class="login-form" novalidate>
      <div class="form-group">
        <label for="username">Kullanıcı Adı</label>
        <div class="input-wrap">
          <i data-lucide="user" class="input-icon"></i>
          <input type="text" id="username" name="username" autocomplete="username"
                 placeholder="Kullanıcı adınız"
                 value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required />
        </div>
      </div>
      <div class="form-group">
        <label for="password">Şifre</label>
        <div class="input-wrap">
          <i data-lucide="lock" class="input-icon"></i>
          <input type="password" id="password" name="password" autocomplete="current-password"
                 placeholder="••••••••" required />
        </div>
      </div>
      <div class="form-check">
        <input type="checkbox" id="remember" name="remember" value="1" />
        <label for="remember">Beni hatırla (7 gün)</label>
      </div>
      <button type="submit" class="btn btn--primary btn--full">
        <i data-lucide="log-in"></i> Giriş Yap
      </button>
    </form>
  </div>
  <script>lucide.createIcons();</script>
</body>
</html>

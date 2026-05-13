<?php
/**
 * Auth helpers — session & cookie based admin guard.
 */

session_start();

define('SESSION_KEY',  'portfolio_admin');
define('COOKIE_NAME',  'portfolio_remember');
define('COOKIE_TTL',   60 * 60 * 24 * 7); // 7 days

/**
 * Returns true if the current visitor is a logged-in admin.
 */
function isLoggedIn(): bool {
    if (!empty($_SESSION[SESSION_KEY])) {
        return true;
    }
    // Remember-me cookie check
    if (!empty($_COOKIE[COOKIE_NAME])) {
        require_once __DIR__ . '/db.php';
        $pdo  = getPDO();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$_COOKIE[COOKIE_NAME]]);
        if ($stmt->fetch()) {
            $_SESSION[SESSION_KEY] = $_COOKIE[COOKIE_NAME];
            return true;
        }
    }
    return false;
}

/**
 * Redirect to login if not authenticated.
 */
function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /admin/index.php');
        exit;
    }
}

/**
 * Destroy session and cookie on logout.
 */
function logout(): void {
    $_SESSION = [];
    session_destroy();
    if (isset($_COOKIE[COOKIE_NAME])) {
        setcookie(COOKIE_NAME, '', time() - 3600, '/', '', true, true);
    }
}

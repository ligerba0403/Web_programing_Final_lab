<?php
/**
 * Database Connection
 * Uses PDO with prepared statements for security.
 */

define('DB_HOST', 'sql210.infinityfree.com');
define('DB_NAME', 'if0_41916414_portfolio_db');
define('DB_USER', 'if0_41916414');
define('DB_PASS', 'GpNB5lv8HV');  // göz ikonuyla gördüğün şifreyi yaz
define('DB_CHARSET', 'utf8mb4');

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
        }
    }
    return $pdo;
}

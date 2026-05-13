<?php
/**
 * POST /api/send_message.php
 * Validates and saves a contact form submission.
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

require_once __DIR__ . '/../includes/db.php';

// --- Sanitize & Validate ---
$name    = trim(strip_tags($_POST['name']    ?? ''));
$email   = trim(strip_tags($_POST['email']   ?? ''));
$subject = trim(strip_tags($_POST['subject'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

$errors = [];

if (strlen($name) < 2)                              $errors[] = 'Geçerli bir isim girin.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL))     $errors[] = 'Geçerli bir e-posta girin.';
if (strlen($subject) < 3)                           $errors[] = 'Konu en az 3 karakter olmalı.';
if (strlen($message) < 10)                          $errors[] = 'Mesaj en az 10 karakter olmalı.';

if ($errors) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// --- Rate limiting (simple: 3 messages per IP per hour) ---
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';

try {
    $pdo = getPDO();

    $check = $pdo->prepare(
        'SELECT COUNT(*) FROM messages WHERE ip_address = ? AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)'
    );
    $check->execute([$ip]);
    if ((int)$check->fetchColumn() >= 3) {
        http_response_code(429);
        echo json_encode(['success' => false, 'message' => 'Çok fazla istek. Lütfen bir saat sonra tekrar deneyin.']);
        exit;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO messages (name, email, subject, message, ip_address) VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([$name, $email, $subject, $message, $ip]);

    echo json_encode(['success' => true, 'message' => 'Mesajınız alındı.']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Sunucu hatası, lütfen tekrar deneyin.']);
}

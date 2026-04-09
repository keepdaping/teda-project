<?php
header('Content-Type: application/json; charset=utf-8');

session_start();

/* ── CSRF check ──────────────────────────────────────────── */
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

/* ── Rate limiting (5 submissions per minute per session) ── */
$rkey = 'rate_contact_' . md5($_SERVER['REMOTE_ADDR'] ?? '');
if (!isset($_SESSION[$rkey])) $_SESSION[$rkey] = ['count' => 0, 'ts' => time()];
if (time() - $_SESSION[$rkey]['ts'] > 60) $_SESSION[$rkey] = ['count' => 0, 'ts' => time()];
if (++$_SESSION[$rkey]['count'] > 5) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please wait a minute.']);
    exit;
}

include __DIR__ . '/db.php';

// Get and sanitize input
$name    = isset($_POST['name'])    ? trim($_POST['name'])    : '';
$email   = isset($_POST['email'])   ? trim($_POST['email'])   : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
} elseif (strlen($name) > 100) {
    $errors[] = 'Name must be less than 100 characters';
}

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if (empty($message)) {
    $errors[] = 'Message is required';
} elseif (strlen($message) > 1000) {
    $errors[] = 'Message must be less than 1000 characters';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");

if (!$stmt) {
    error_log('contact_messages prepare failed: ' . $conn->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again.']);
    exit;
}

$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => "Message sent successfully! We'll get back to you soon."]);
} else {
    error_log('Contact message insert error: ' . $stmt->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error sending message. Please try again.']);
}

$stmt->close();
$conn->close();
?>

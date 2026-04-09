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
$rkey = 'rate_membership_' . md5($_SERVER['REMOTE_ADDR'] ?? '');
if (!isset($_SESSION[$rkey])) $_SESSION[$rkey] = ['count' => 0, 'ts' => time()];
if (time() - $_SESSION[$rkey]['ts'] > 60) $_SESSION[$rkey] = ['count' => 0, 'ts' => time()];
if (++$_SESSION[$rkey]['count'] > 5) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please wait a minute.']);
    exit;
}

include __DIR__ . '/db.php';

// Get and sanitize input
$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email    = isset($_POST['email'])    ? trim($_POST['email'])    : '';
$phone    = isset($_POST['phone'])    ? trim($_POST['phone'])    : '';
$message  = isset($_POST['message'])  ? trim($_POST['message'])  : '';

// Validation
$errors = [];

if (empty($fullname)) {
    $errors[] = 'Full name is required';
} elseif (strlen($fullname) > 100) {
    $errors[] = 'Full name must be less than 100 characters';
}

if (empty($email)) {
    $errors[] = 'Email is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if (empty($phone)) {
    $errors[] = 'Phone number is required';
} elseif (!preg_match('/^[\d+\-\s()]+$/', $phone) || strlen($phone) < 7) {
    $errors[] = 'Invalid phone number';
}

if (empty($message)) {
    $errors[] = 'Message is required';
} elseif (strlen($message) > 500) {
    $errors[] = 'Message must be less than 500 characters';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO membership (fullname, email, phone, message) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    error_log('membership prepare failed: ' . $conn->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again.']);
    exit;
}

$stmt->bind_param("ssss", $fullname, $email, $phone, $message);

if ($stmt->execute()) {

    // Send plain-text email notification (no htmlspecialchars in plain-text body)
    $to      = "tedayouthteso@gmail.com";
    $subject = "New TEDA Membership Application";
    $body    = "Name: {$fullname}\nEmail: {$email}\nPhone: {$phone}\nMessage: {$message}";
    $sent    = mail($to, $subject, $body);
    if (!$sent) {
        error_log('mail() failed for membership submission from: ' . $email);
    }

    // WhatsApp deep-link for quick follow-up
    $whatsappText = urlencode("NEW TEDA APPLICATION:\nName: {$fullname}\nPhone: {$phone}\nEmail: {$email}");
    $whatsappLink = "https://wa.me/256775375249?text={$whatsappText}";

    echo json_encode([
        'success'      => true,
        'message'      => 'Thank you! Your application has been submitted.',
        'whatsappLink' => $whatsappLink,
    ]);

} else {
    error_log('Membership insert error: ' . $stmt->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error submitting application. Please try again.']);
}

$stmt->close();
$conn->close();
?>

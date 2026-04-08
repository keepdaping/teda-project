<?php
include __DIR__ . '/db.php';

// Get and sanitize input
$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validation
$errors = array();

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

// If validation fails, return error
if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'message' => implode(', ', $errors)
    ]);
    http_response_code(400);
    exit;
}

// Prepare statement (SECURE - prevents SQL injection)
$stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error. Please try again.'
    ]);
    http_response_code(500);
    exit;
}

// Bind parameters
$stmt->bind_param("sss", $name, $email, $message);

// Execute query
if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Message sent successfully! We\'ll get back to you soon.'
    ]);
} else {
    // Log error but don't expose to user
    error_log("Contact message insert error: " . $stmt->error);
    echo json_encode([
        'success' => false,
        'message' => 'Error sending message. Please try again.'
    ]);
    http_response_code(500);
}

$stmt->close();
$conn->close();
?>

<?php
include __DIR__ . '/db.php';

// Get and sanitize input
$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$email   = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';
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
$stmt = $conn->prepare("INSERT INTO applications (name, email, phone, message) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error. Please try again.'
    ]);
    http_response_code(500);
    exit;
}

// Bind parameters
$stmt->bind_param("ssss", $name, $email, $phone, $message);

// Execute query
if ($stmt->execute()) {

    // Send email notification
    $to      = "tedayouthteso@gmail.com";
    $subject = "New TEDA Application";
    $body    = "Name: " . htmlspecialchars($name) . "\nEmail: " . htmlspecialchars($email) . "\nPhone: " . htmlspecialchars($phone) . "\nMessage: " . htmlspecialchars($message);
    @mail($to, $subject, $body);

    // Return success response with WhatsApp link
    $whatsappText = urlencode("New Application:\nName: " . $name . "\nPhone: " . $phone);
    $whatsappLink = "https://wa.me/256775375249?text=" . $whatsappText;

    echo json_encode([
        'success' => true,
        'message' => 'Application submitted successfully!',
        'whatsappLink' => $whatsappLink
    ]);

} else {
    // Log error but don't expose to user
    error_log("Application insert error: " . $stmt->error);
    echo json_encode([
        'success' => false,
        'message' => 'Error submitting application. Please try again.'
    ]);
    http_response_code(500);
}

$stmt->close();
$conn->close();
?>

<?php
include __DIR__ . '/db.php';

// Get and sanitize input
$fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone    = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$message  = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validation
$errors = array();

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

// If validation fails, show error response
if (!empty($errors)) {
    echo json_encode([
        'success' => false,
        'message' => implode(', ', $errors)
    ]);
    http_response_code(400);
    exit;
}

// Prepare statement (SECURE - prevents SQL injection)
$stmt = $conn->prepare("INSERT INTO membership (fullname, email, phone, message) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error. Please try again.'
    ]);
    http_response_code(500);
    exit;
}

// Bind parameters (s = string type)
$stmt->bind_param("ssss", $fullname, $email, $phone, $message);

// Execute query
if ($stmt->execute()) {

    // Send email notification
    $to      = "tedayouthteso@gmail.com";
    $subject = "New TEDA Membership Application";
    $body    = "Name: " . htmlspecialchars($fullname) . "\nEmail: " . htmlspecialchars($email) . "\nPhone: " . htmlspecialchars($phone) . "\nMessage: " . htmlspecialchars($message);
    @mail($to, $subject, $body);

    // Return success response with WhatsApp link
    $whatsappText = urlencode("NEW TEDA APPLICATION:\nName: " . $fullname . "\nPhone: " . $phone . "\nEmail: " . $email);
    $whatsappLink = "https://wa.me/256775375249?text=" . $whatsappText;

    echo json_encode([
        'success' => true,
        'message' => 'Thank you! Your application has been submitted.',
        'whatsappLink' => $whatsappLink
    ]);

} else {
    // Log error but don't expose to user
    error_log("Membership insert error: " . $stmt->error);
    echo json_encode([
        'success' => false,
        'message' => 'Error submitting application. Please try again.'
    ]);
    http_response_code(500);
}

$stmt->close();
$conn->close();
?>

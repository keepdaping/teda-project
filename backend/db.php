<?php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "teda_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    error_log('DB connection failed: ' . $conn->connect_error);
    http_response_code(503);
    echo json_encode(['success' => false, 'message' => 'Service temporarily unavailable.']);
    exit;
}
?>

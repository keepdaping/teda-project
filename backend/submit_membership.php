<?php
include __DIR__ . '/db.php';

$fullname = $_POST['fullname'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$message  = $_POST['message'];

$sql = "INSERT INTO membership (fullname, email, phone, message)
        VALUES ('$fullname', '$email', '$phone', '$message')";

if ($conn->query($sql) === TRUE) {

    // EMAIL ALERT
    $to      = "tedayouthteso@gmail.com";
    $subject = "New TEDA Membership Application";
    $body    = "Name: $fullname\nEmail: $email\nPhone: $phone\nMessage: $message";
    mail($to, $subject, $body);

    // WHATSAPP AUTO-OPEN
    $text = urlencode("NEW TEDA APPLICATION:\nName: $fullname\nPhone: $phone\nEmail: $email");

    echo "
    <html><body>
    <script>
        alert('Application submitted successfully!');
        window.open('https://wa.me/256775375249?text=$text', '_blank');
        window.location.href = '../index.php';
    </script>
    </body></html>
    ";

} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

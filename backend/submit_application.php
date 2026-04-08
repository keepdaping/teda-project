<?php
include __DIR__ . '/db.php';

$name    = $_POST['name'];
$email   = $_POST['email'];
$phone   = $_POST['phone'];
$message = $_POST['message'];

$sql = "INSERT INTO applications (name, email, phone, message)
        VALUES ('$name', '$email', '$phone', '$message')";

if ($conn->query($sql) === TRUE) {

    // EMAIL NOTIFICATION
    $to      = "tedayouthteso@gmail.com";
    $subject = "New TEDA Application";
    $body    = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
    mail($to, $subject, $body);

    // WHATSAPP MESSAGE
    $whatsappMessage = urlencode("New Application:\nName: $name\nPhone: $phone");
    $whatsappLink    = "https://wa.me/256775375249?text=$whatsappMessage";

    echo "
    <script>
        alert('Application submitted successfully!');
        window.location.href = '$whatsappLink';
    </script>
    ";

} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>

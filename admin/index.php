<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEDA Admin</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<header>
    <h1>TEDA Admin Dashboard</h1>
</header>

<?php
include __DIR__ . '/../backend/db.php';
?>

<section>
    <h2>Membership Applications</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM membership");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['fullname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['message']}</td>
            </tr>";
        }
        ?>
    </table>
</section>

<section>
    <h2>Contact Messages</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM contact_messages");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['message']}</td>
            </tr>";
        }
        ?>
    </table>
</section>

<footer>
    <p>&copy; 2026 TEDA Admin</p>
</footer>

</body>
</html>

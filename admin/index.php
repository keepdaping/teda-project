<?php
/* ── Authentication guard — MUST be first ─────────────── */
session_start();

require_once __DIR__ . '/../backend/config.php';

/* Redirect to login if not authenticated */
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

/* Session timeout — log out after inactivity */
if (isset($_SESSION['admin_last_seen']) &&
    (time() - $_SESSION['admin_last_seen']) > SESSION_TIMEOUT) {
    session_destroy();
    header('Location: login.php?logged_out=1');
    exit;
}
$_SESSION['admin_last_seen'] = time();
/* ──────────────────────────────────────────────────────── */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEDA Admin — Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>


<?php
include __DIR__ . '/../backend/db.php';

$memberCount  = $conn->query("SELECT COUNT(*) AS c FROM membership")->fetch_assoc()['c']  ?? 0;
$contactCount = $conn->query("SELECT COUNT(*) AS c FROM contact_messages")->fetch_assoc()['c'] ?? 0;
?>

<header class="admin-header">
    <h1>TEDA Admin Dashboard</h1>
    <p>Teso Elites Development Association — internal view</p>
</header>

<nav>
    <a href="../index.php">&#8592; Back to Site</a>
    <a href="#membership" class="active">Membership</a>
    <a href="#contact">Contact</a>
    <a href="logout.php" style="margin-left:auto;color:rgba(255,255,255,0.45)">Sign out</a>
</nav>

<div class="section">
    <div class="container">

        <!-- Stats -->
        <div class="stat-row">
            <div class="stat-chip">
                <strong><?= (int)$memberCount ?></strong>
                <span>Membership Applications</span>
            </div>
            <div class="stat-chip">
                <strong><?= (int)$contactCount ?></strong>
                <span>Contact Messages</span>
            </div>
        </div>

        <!-- Membership table -->
        <div id="membership" class="admin-block">
            <span class="label">Applications</span>
            <h2>Membership</h2>

            <?php
            $result = $conn->query("SELECT * FROM membership ORDER BY id DESC");
            if ($result && $result->num_rows > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><span class="badge badge-new">New</span> <?= htmlspecialchars($row['fullname']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['phone']) ?></td>
                            <td><?= htmlspecialchars($row['message']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="empty-state">No membership applications yet.</p>
            <?php endif; ?>
        </div>

        <hr class="admin-divider">

        <!-- Contact table -->
        <div id="contact" class="admin-block">
            <span class="label">Inbox</span>
            <h2>Contact Messages</h2>

            <?php
            $result = $conn->query("SELECT * FROM contact_messages ORDER BY id DESC");
            if ($result && $result->num_rows > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><span class="badge badge-new">New</span> <?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['message']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="empty-state">No contact messages yet.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php $conn->close(); ?>

<footer>
    <div class="footer-inner">
        <div>
            <p class="footer-brand">TEDA</p>
            <p class="footer-tagline">Admin Dashboard — internal use only.</p>
        </div>
        <ul class="footer-links">
            <li><a href="../index.php">Main Site</a></li>
            <li><a href="#membership">Membership</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>
    <p class="footer-bottom">&copy; 2026 TEDA. All rights reserved.</p>
</footer>

<!-- Toast Notification System -->
<script>
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'toast-out 0.3s var(--ease) forwards';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TEDA — Setup Admin Password</title>
    <style>
        body { font-family: monospace; background: #0d1117; color: #c9d1d9;
               display: flex; align-items: center; justify-content: center;
               min-height: 100vh; margin: 0; }
        .box { background: #161b22; border: 1px solid #30363d; border-radius: 8px;
               padding: 32px; max-width: 540px; width: 100%; }
        h1   { color: #fff; font-size: 18px; margin: 0 0 6px; }
        p    { color: #8b949e; font-size: 13px; margin: 0 0 24px; }
        label { display: block; font-size: 12px; color: #8b949e;
                text-transform: uppercase; letter-spacing: .08em; margin-bottom: 6px; }
        input { width: 100%; box-sizing: border-box; background: #0d1117;
                border: 1px solid #30363d; color: #fff; padding: 9px 12px;
                border-radius: 6px; font-size: 14px; margin-bottom: 16px; }
        input:focus { outline: none; border-color: #58a6ff; }
        button { background: #238636; color: #fff; border: none; padding: 10px 20px;
                 border-radius: 6px; font-size: 14px; cursor: pointer; width: 100%; }
        button:hover { background: #2ea043; }
        .result { background: #0d1117; border: 1px solid #30363d; border-radius: 6px;
                  padding: 16px; margin-top: 20px; word-break: break-all; }
        .result .label { color: #8b949e; font-size: 11px; text-transform: uppercase;
                         letter-spacing: .08em; margin-bottom: 8px; display: block; }
        .hash  { color: #56d364; font-size: 13px; }
        .warn  { background: #3d1f00; border: 1px solid #d29922; border-radius: 6px;
                 padding: 12px 16px; font-size: 13px; color: #d29922; margin-top: 20px; }
    </style>
</head>
<body>
<div class="box">
    <h1>Admin Password Setup</h1>
    <p>Enter your credentials below. Copy the generated hash into <code>backend/config.php</code>,
       then <strong>delete this file immediately</strong>.</p>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');

    $errors = [];
    if (strlen($username) < 3)  $errors[] = 'Username must be at least 3 characters.';
    if (strlen($password) < 10) $errors[] = 'Password must be at least 10 characters.';
    if ($password !== $confirm)  $errors[] = 'Passwords do not match.';

    if ($errors) {
        foreach ($errors as $e) echo '<p style="color:#f85149;margin:0 0 8px">' . htmlspecialchars($e) . '</p>';
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        echo '<div class="result">';
        echo '<span class="label">Paste these into backend/config.php</span>';
        echo '<code class="hash">define(\'ADMIN_USERNAME\', \'' . htmlspecialchars($username) . '\');<br>';
        echo 'define(\'ADMIN_PASSWORD_HASH\', \'' . $hash . '\');</code>';
        echo '</div>';
        echo '<div class="warn">⚠ Copy the values above, update config.php, then DELETE this file.</div>';
    }
}
?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" value="admin" autocomplete="off" required>
        <label>Password (min 10 characters)</label>
        <input type="password" name="password" required>
        <label>Confirm Password</label>
        <input type="password" name="confirm" required>
        <button type="submit">Generate Hash</button>
    </form>
</div>
</body>
</html>

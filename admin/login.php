<?php
session_start();

require_once __DIR__ . '/../backend/config.php';

/* ── Already logged in? Go straight to dashboard ─────── */
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error         = '';
$using_default = (ADMIN_PASSWORD_HASH === '$2y$12$defaultHashReplaceThisNowXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

/* ── Handle login form submission ──────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* Basic rate limiting — max 5 attempts per session */
    if (!isset($_SESSION['login_attempts'])) $_SESSION['login_attempts'] = 0;
    if (!isset($_SESSION['lockout_until']))  $_SESSION['lockout_until']  = 0;

    if (time() < $_SESSION['lockout_until']) {
        $wait  = ceil(($_SESSION['lockout_until'] - time()) / 60);
        $error = "Too many failed attempts. Try again in {$wait} minute(s).";
    } else {
        $posted_user = trim($_POST['username'] ?? '');
        $posted_pass = trim($_POST['password'] ?? '');

        $user_ok = hash_equals(ADMIN_USERNAME, $posted_user);
        $pass_ok = !$using_default && password_verify($posted_pass, ADMIN_PASSWORD_HASH);

        if ($user_ok && $pass_ok) {
            /* Success — regenerate session ID to prevent fixation */
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user']      = ADMIN_USERNAME;
            $_SESSION['admin_last_seen'] = time();
            $_SESSION['login_attempts']  = 0;

            header('Location: index.php');
            exit;
        } else {
            $_SESSION['login_attempts']++;
            if ($_SESSION['login_attempts'] >= 5) {
                $_SESSION['lockout_until'] = time() + 300; // 5-minute lockout
                $error = 'Too many failed attempts. Locked out for 5 minutes.';
            } else {
                /* Constant-time sleep to prevent timing attacks */
                usleep(300000);
                $error = 'Invalid username or password.';
            }
        }
    }
}

/* ── Build the "logged out" flash message ──────────────── */
$logged_out = isset($_GET['logged_out']) && $_GET['logged_out'] === '1';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TEDA Admin — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: linear-gradient(135deg, #3d1206 0%, #1a0803 50%, #0a0401 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        .login-wrap {
            width: 100%;
            max-width: 400px;
        }

        /* Brand */
        .brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-name {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.04em;
        }

        .brand-sub {
            font-size: 12px;
            color: rgba(255,255,255,0.38);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* Card */
        .card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 14px;
            padding: 36px 32px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .card-title {
            font-size: 17px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 6px;
        }

        .card-sub {
            font-size: 13px;
            color: rgba(255,255,255,0.45);
            margin-bottom: 28px;
        }

        /* Alerts */
        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .alert-error {
            background: rgba(248,81,73,0.12);
            border: 1px solid rgba(248,81,73,0.30);
            color: #f85149;
        }

        .alert-success {
            background: rgba(86,211,100,0.10);
            border: 1px solid rgba(86,211,100,0.25);
            color: #56d364;
        }

        .alert-warning {
            background: rgba(210,153,34,0.12);
            border: 1px solid rgba(210,153,34,0.30);
            color: #d29922;
        }

        /* Form */
        label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.45);
            text-transform: uppercase;
            letter-spacing: 0.10em;
            margin-bottom: 7px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 9px;
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            padding: 11px 14px;
            margin-bottom: 18px;
            transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
            -webkit-appearance: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: rgba(255,255,255,0.40);
            background: rgba(255,255,255,0.10);
            box-shadow: 0 0 0 3px rgba(255,255,255,0.06);
        }

        input::placeholder { color: rgba(255,255,255,0.25); }

        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #5c1f0d, #7a2912);
            color: #fff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            transition: opacity 0.18s, box-shadow 0.18s;
            box-shadow: 0 4px 16px rgba(92,31,13,0.40);
            margin-top: 4px;
        }

        button[type="submit"]:hover {
            opacity: 0.88;
            box-shadow: 0 6px 22px rgba(92,31,13,0.55);
        }

        /* Footer */
        .back-link {
            text-align: center;
            margin-top: 22px;
            font-size: 12px;
            color: rgba(255,255,255,0.30);
        }

        .back-link a {
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            transition: color 0.15s;
        }

        .back-link a:hover { color: rgba(255,255,255,0.90); }
    </style>
</head>
<body>

<div class="login-wrap">

    <div class="brand">
        <div class="brand-name">TEDA</div>
        <div class="brand-sub">Admin Portal</div>
    </div>

    <div class="card">
        <div class="card-title">Sign in</div>
        <div class="card-sub">Restricted access — authorised personnel only.</div>

        <?php if ($using_default): ?>
        <div class="alert alert-warning">
            ⚠ Default credentials are set. Run <code>setup_password.php</code> to configure a secure password before going live.
        </div>
        <?php endif; ?>

        <?php if ($logged_out): ?>
        <div class="alert alert-success">You have been signed out successfully.</div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" autocomplete="off">
            <label for="username">Username</label>
            <input type="text"
                   id="username"
                   name="username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                   autocomplete="username"
                   placeholder="Enter username"
                   required>

            <label for="password">Password</label>
            <input type="password"
                   id="password"
                   name="password"
                   autocomplete="current-password"
                   placeholder="Enter password"
                   required>

            <button type="submit">Sign In</button>
        </form>
    </div>

    <div class="back-link"><a href="../index.php">← Back to main site</a></div>
</div>

</body>
</html>

<?php
/**
 * Admin credentials configuration.
 *
 * SETUP INSTRUCTIONS (do this once before going live):
 *
 *  1. Open admin/setup_password.php in your browser.
 *  2. Enter your chosen username and password.
 *  3. Copy the generated hash into ADMIN_PASSWORD_HASH below.
 *  4. DELETE admin/setup_password.php immediately after.
 *
 * Until you complete setup, the default credentials are:
 *   Username : admin
 *   Password : TEDAadmin2026
 *
 * NEVER leave default credentials in production.
 */

define('ADMIN_USERNAME',      'admin');

// Default hash is for the password: TEDAadmin2026
// Replace with the output from admin/setup_password.php
define('ADMIN_PASSWORD_HASH', '$2y$12$defaultHashReplaceThisNowXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');

/**
 * Session lifetime in seconds (30 minutes).
 * Admin is logged out automatically after this period of inactivity.
 */
define('SESSION_TIMEOUT', 1800);

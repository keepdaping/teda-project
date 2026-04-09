# TEDA — Teso Elites Development Association

A PHP/HTML website for TEDA — a youth-led organisation driving change across Teso through education, leadership, and community development.

---

## Project Structure

```
teda/
├── index.php                  # Main public-facing site
├── admin/
│   ├── index.php              # Admin dashboard (auth-protected)
│   ├── login.php              # Admin login page
│   ├── logout.php             # Session teardown
│   └── setup_password.php     # One-time password setup tool — DELETE after use
├── backend/
│   ├── config.php             # Admin credentials & session config
│   ├── db.php                 # Database connection
│   ├── submit_contact.php     # Contact form handler (JSON)
│   └── submit_membership.php  # Membership form handler (JSON)
└── public/
    ├── css/style.css          # Single stylesheet for all pages
    ├── js/main.js             # Navigation, carousel, forms, scroll reveal
    ├── js/effects.js          # Parallax, particles, card 3D tilt
    └── images/                # All project images
```

---

## Requirements

- PHP 7.4+
- MySQL / MariaDB
- A local server: XAMPP, WAMP, Laragon, or equivalent

---

## Local Setup

1. **Clone the repo** into your web server's root folder:
   ```bash
   git clone https://github.com/keepdaping/teda-project.git teda
   ```

2. **Create the database** — import the schema into MySQL:
   ```sql
   CREATE DATABASE teda_db;
   USE teda_db;

   CREATE TABLE contact_messages (
       id      INT AUTO_INCREMENT PRIMARY KEY,
       name    VARCHAR(100)  NOT NULL,
       email   VARCHAR(150)  NOT NULL,
       message TEXT          NOT NULL,
       created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );

   CREATE TABLE membership (
       id       INT AUTO_INCREMENT PRIMARY KEY,
       fullname VARCHAR(100) NOT NULL,
       email    VARCHAR(150) NOT NULL,
       phone    VARCHAR(30)  NOT NULL,
       message  TEXT,
       created  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   );
   ```

3. **Configure database credentials** in `backend/db.php`:
   ```php
   $host     = "localhost";
   $user     = "your_db_user";
   $password = "your_db_password";
   $database = "teda_db";
   ```

4. **Set up admin credentials**:
   - Open `http://localhost/teda/admin/setup_password.php` in your browser.
   - Enter a username and a strong password (min 10 characters).
   - Copy the generated `define()` lines into `backend/config.php`.
   - **Delete `admin/setup_password.php` immediately after.**

5. **Visit the site**: `http://localhost/teda/`

---

## Admin Dashboard

- URL: `http://localhost/teda/admin/`
- Protected by session-based login with bcrypt password hashing.
- Auto-logout after 30 minutes of inactivity.
- Rate-limited to 5 login attempts before a 5-minute lockout.

---

## Security Notes

- All form submissions are protected with CSRF tokens.
- Form handlers are rate-limited (5 requests/min per session).
- Database queries use prepared statements throughout.
- Database errors are logged server-side only — nothing is exposed to the browser.
- `admin/setup_password.php` **must be deleted** before going to production.

---

## Contributing

1. Fork the repository.
2. Create a feature branch: `git checkout -b feature/your-feature`.
3. Commit your changes: `git commit -m "Add your feature"`.
4. Push and open a Pull Request.

---

&copy; 2026 TEDA. All rights reserved.

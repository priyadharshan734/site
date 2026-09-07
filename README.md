# Forthright & Oak — Construction & Interior Design Website

A responsive, animated marketing site for a construction / interior design
company, with a PHP + MySQL backend for the project gallery and contact form.

## Structure

```
├── index.php                     Homepage (hero, services, gallery, process)
├── contact.php                   Contact page + form
├── services/
│   ├── home-building.php
│   ├── interior-design.php
│   └── exterior-work.php
├── css/
│   ├── style.css                 Design tokens + layout/components
│   └── animations.css            All keyframes, hand-authored
├── js/
│   └── main.js                   Nav, hero animation, gallery, form, accordion
├── admin/                         Password-protected staff area (not linked publicly)
│   ├── login.php / logout.php
│   ├── dashboard.php              Metrics + recent inquiries
│   ├── messages.php               View/update/delete contact-form leads
│   ├── projects.php               Add/remove gallery projects
│   ├── testimonials.php           Add/publish/delete testimonials
│   └── includes/
│       ├── auth.php               Session guard, CSRF helpers
│       ├── admin-header.php
│       └── admin-footer.php
└── php/
    ├── config.php                 DB credentials & app constants
    ├── functions.php              PDO connection, JSON helpers, rate limiting
    ├── get_projects.php           GET endpoint — completed projects (JSON)
    ├── contact_handler.php        POST endpoint — validates & stores leads
    ├── create_admin_cli.php       CLI tool to create/reset an admin login
    ├── db_schema.sql              MySQL schema + seed data
    └── partials/
        ├── header.php             Shared <head> + nav
        └── footer.php             Shared footer + script include
```

## Local setup

1. **Database**
   ```bash
   mysql -u root -p < php/db_schema.sql
   ```
   This creates the `forthright_oak` database, a least-privilege
   `forthright_app` DB user, and seeds sample services/projects/testimonials.

2. **Configuration**
   Edit `php/config.php` or set environment variables:
   `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`, `COMPANY_NOTIFY_EMAIL`, `APP_ENV`.
   Never commit real production credentials.

3. **Run**
   Any PHP 8+ / MySQL 8+ stack works. Quickest local option:
   ```bash
   php -S localhost:8000
   ```
   then visit `http://localhost:8000/index.php`.

## How the dynamic parts work

- **Project gallery** — `js/main.js` calls `php/get_projects.php` (optionally
  `?category=home-building`) and renders cards client-side. If the endpoint
  is unreachable (e.g. opening the HTML without a PHP server), it falls back
  to bundled sample data so the page still demonstrates correctly.
- **Contact form** — `contact.php` posts JSON to `php/contact_handler.php`,
  which validates input server-side, rate-limits by IP, stores the lead in
  the `messages` table, and best-effort emails your team. A hidden honeypot
  field filters basic bots.

## Connecting MySQL Workbench to this project

1. **Open MySQL Workbench** → click the **+** next to "MySQL Connections" on the home screen.
2. **Name the connection** (e.g. `Forthright & Oak — Local`).
3. **Connection method:** Standard (TCP/IP).
4. **Hostname:** `127.0.0.1` (or your DB server's address) · **Port:** `3306`.
5. **Username:** `root` (for setup) — click **Store in Vault…** and enter your MySQL root password so you're not prompted every time.
6. Click **Test Connection** to confirm it connects, then **OK** to save.
7. Double-click the new connection to open a SQL editor.
8. **Import the schema:** `File → Open SQL Script…` → select `php/db_schema.sql` → click the lightning-bolt "Execute" icon to run the whole file. This creates the `forthright_oak` database, the `forthright_app` DB user, and all tables with seed data.
9. In the left **Navigator → Schemas** panel, right-click and **Refresh All** — you should now see `forthright_oak` with tables: `services`, `projects`, `testimonials`, `messages`, `admin_users`.
10. To browse data visually: click the table (e.g. `messages`) → the grid/table icon → **Select Rows - Limit 1000**, or just double-click the table name in the schema tree.
11. **Point the app at this database** by editing `php/config.php` (or setting env vars) to match what you used in Workbench:
    ```php
    define('DB_HOST', '127.0.0.1');
    define('DB_NAME', 'forthright_oak');
    define('DB_USER', 'forthright_app');
    define('DB_PASS', 'change-me'); // match the password set in db_schema.sql
    ```
12. For a **remote/production DB**, add a new Workbench connection with that server's hostname/port, and make sure the DB server's firewall allows your IP (or use an SSH tunnel via Workbench's "Connection Method: Standard TCP/IP over SSH").

## Admin panel — view data no public visitor can see

The `/admin` folder is a separate, password-protected area for staff: it shows every contact-form submission (`messages`), lets you manage the project gallery and testimonials, and is never linked from the public pages.

### 1. Create the database objects (if not already done)
```bash
mysql -u root -p < php/db_schema.sql
```
This adds the `admin_users` table alongside the existing ones.

### 2. Create your first admin account
Run this from the command line on the server (never over HTTP):
```bash
php php/create_admin_cli.php "Jane Doe" jane@forthrightandoak.com
```
You'll be prompted to type a password (minimum 10 characters). It's hashed with `password_hash()` before it's stored — the plaintext never touches the database or a log file. Run the same command again with the same email to reset a forgotten password.

### 3. Log in
Visit `/admin/login.php` and sign in with the email/password you just created. Sessions are cookie-based, `httponly`, and auto-expire after 45 minutes of inactivity.

### 4. What you get access to
| Page | Purpose |
|---|---|
| `admin/dashboard.php` | Inquiry counts, project/testimonial totals, 6 most recent leads |
| `admin/messages.php` | Every contact-form submission — filter by status, update status (new/contacted/archived), delete |
| `admin/projects.php` | Add new completed projects (they appear on the public gallery immediately) or remove old ones |
| `admin/testimonials.php` | Add, publish/unpublish, or delete client testimonials |

None of this is reachable from the public site's navigation — someone would need the exact `/admin/login.php` URL and valid credentials.

### 5. Hardening checklist before going live
- Change the seed DB password in `db_schema.sql`/`config.php` — never ship `change-me`.
- Put `/admin` behind an extra layer if you want belt-and-braces protection: an `.htaccess` IP allowlist, HTTP Basic Auth in front of the PHP auth, or a VPN.
- Serve everything over HTTPS — session cookies are marked `secure` automatically once `$_SERVER['HTTPS']` is set, so this mostly just means installing a TLS certificate.
- Consider a dedicated MySQL user for the admin panel with `DELETE` privileges scoped only to `messages`, `projects`, and `testimonials` (not `admin_users`), so a compromised app can't rewrite its own accounts.
- Add 2FA or an account-lockout policy if this will hold sensitive lead data long-term — the current rate limiter only slows down brute-force login attempts (8 tries / 15 min per IP).



- Swap the Unsplash placeholder photos for real project photography —
  update `image_url` values in `db_schema.sql` or directly in the `projects`
  table once it's live.
- Brand colors, type, and spacing all live as CSS custom properties at the
  top of `css/style.css` — change the palette in one place.
- The hero's line-drawing animation is hand-built SVG in `index.php`
  (`.hero-blueprint`); adjust the `<line>`/`<path>` coordinates to trace a
  different structure if you change the hero photo.

## Production checklist

- Set `ALLOWED_ORIGIN` in `config.php` to your real domain (not `*`).
- Replace PHP's `mail()` in `contact_handler.php` with a transactional email
  provider (SES, Postmark, SendGrid) for reliable delivery.
- Serve over HTTPS and set `session.cookie_secure` / standard PHP hardening
  if you add authenticated admin screens later.
- Add an admin view over the `messages` table (or connect it to your CRM) —
  none is included here to keep the public-facing scope focused.

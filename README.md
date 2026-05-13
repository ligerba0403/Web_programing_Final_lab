# Personal Portfolio — Full-Stack Web Project

A full-stack personal portfolio built with **HTML5, CSS3, Vanilla JavaScript, PHP 8+, and MySQL**.

## Tech Stack

| Layer      | Technology                  |
|------------|-----------------------------|
| Frontend   | Semantic HTML5, CSS3 (Grid/Flexbox), Vanilla JS |
| Backend    | PHP 8+ (no framework)       |
| Database   | MySQL                        |
| Data Layer | AJAX via Fetch API           |

## Features

- Dark / Light mode toggle (persisted via localStorage)
- Typing effect hero section
- Filterable project grid (loaded via AJAX)
- Contact form with client-side validation + server-side save
- Scroll reveal animations
- Admin panel with session/cookie auth
- Full CRUD for projects
- Rate-limited contact form (3 msg/IP/hour)

## Setup

1. Import `database.sql` into MySQL
2. Edit `includes/db.php` — set your DB credentials
3. Serve with Apache/Nginx + PHP 8+
4. Visit `http://localhost/` for the portfolio
5. Visit `http://localhost/admin/` for the admin panel

**Admin credentials:** `admin` / `Admin123!`

> Change the password hash in `database.sql` before deploying to production.
> Use `password_hash('YourNewPassword', PASSWORD_BCRYPT)` to generate a new hash.

## Project Structure

```
portfolio/
├── index.html
├── database.sql
├── .gitignore
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   └── images/
├── api/
│   ├── get_projects.php
│   └── send_message.php
├── admin/
│   ├── index.php
│   ├── dashboard.php
│   ├── add_project.php
│   ├── edit_project.php
│   ├── delete_project.php
│   ├── logout.php
│   ├── partials/project_form.php
│   └── assets/css/admin.css + js/admin.js
└── includes/
    ├── db.php
    └── auth.php
```

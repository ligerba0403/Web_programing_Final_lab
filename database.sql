-- ============================================================
-- Personal Portfolio Database
-- Created for: Full-Stack Web Portfolio Project
-- ============================================================

CREATE DATABASE IF NOT EXISTS `portfolio_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `portfolio_db`;

-- ------------------------------------------------------------
-- Table: users (Admin login)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `username`   VARCHAR(50)     NOT NULL UNIQUE,
  `password`   VARCHAR(255)    NOT NULL,  -- bcrypt hash
  `created_at` TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin credentials: username=admin | password=Admin123!
-- Hash generated with password_hash('Admin123!', PASSWORD_BCRYPT)
INSERT INTO `users` (`username`, `password`) VALUES
('admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- ------------------------------------------------------------
-- Table: projects
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id`           INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`        VARCHAR(150)    NOT NULL,
  `description`  TEXT            NOT NULL,
  `image_url`    VARCHAR(500)    NOT NULL DEFAULT 'assets/images/project-placeholder.png',
  `technologies` VARCHAR(300)    NOT NULL,   -- comma-separated: "PHP,MySQL,JS"
  `category`     VARCHAR(80)     NOT NULL DEFAULT 'Web',
  `project_url`  VARCHAR(500)             DEFAULT NULL,
  `github_url`   VARCHAR(500)             DEFAULT NULL,
  `is_featured`  TINYINT(1)      NOT NULL DEFAULT 0,
  `sort_order`   INT UNSIGNED    NOT NULL DEFAULT 0,
  `created_at`   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample projects (placeholder — replace with real ones later)
INSERT INTO `projects`
  (`title`, `description`, `image_url`, `technologies`, `category`, `project_url`, `github_url`, `is_featured`, `sort_order`)
VALUES
(
  'E-Ticaret Platformu',
  'Kullanıcı kaydı, ürün yönetimi ve ödeme entegrasyonu içeren tam kapsamlı bir e-ticaret web uygulaması.',
  'assets/images/project-placeholder.png',
  'PHP,MySQL,JavaScript,CSS3',
  'Web',
  NULL,
  'https://github.com',
  1,
  1
),
(
  'Görev Yönetim Uygulaması',
  'Sürükle-bırak arayüzü ile ekip görevlerini takip etmeye yarayan, gerçek zamanlı güncellemeli proje yönetim aracı.',
  'assets/images/project-placeholder.png',
  'JavaScript,HTML5,CSS3,LocalStorage',
  'Web',
  NULL,
  'https://github.com',
  1,
  2
),
(
  'Hava Durumu Dashboard',
  'OpenWeatherMap API entegrasyonu ile anlık ve 5 günlük hava durumu tahminlerini gösteren responsive dashboard.',
  'assets/images/project-placeholder.png',
  'JavaScript,Fetch API,CSS3,HTML5',
  'API',
  NULL,
  'https://github.com',
  0,
  3
),
(
  'Blog CMS',
  'Markdown desteği, kategori yönetimi ve SEO dostu URL yapısına sahip içerik yönetim sistemi.',
  'assets/images/project-placeholder.png',
  'PHP,MySQL,HTML5,CSS3',
  'Web',
  NULL,
  'https://github.com',
  0,
  4
);

-- ------------------------------------------------------------
-- Table: messages (Contact form submissions)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `messages` (
  `id`         INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(100)    NOT NULL,
  `email`      VARCHAR(150)    NOT NULL,
  `subject`    VARCHAR(200)    NOT NULL,
  `message`    TEXT            NOT NULL,
  `is_read`    TINYINT(1)      NOT NULL DEFAULT 0,
  `ip_address` VARCHAR(45)              DEFAULT NULL,
  `created_at` TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- END OF FILE
-- ============================================================

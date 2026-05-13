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
('admin', '$2y$10$CBPrF6XEOQ.De3nT7AlLv./v3FFz3jivK0ZS.loXOzHdFodM4vwZW');

-- ------------------------------------------------------------
-- Table: projects
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `projects` (
  `id`             INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `title`          VARCHAR(150)    NOT NULL,
  `title_en`       VARCHAR(150)    NOT NULL DEFAULT '',
  `description`    TEXT            NOT NULL,
  `description_en` TEXT            NOT NULL,
  `image_url`      VARCHAR(500)    NOT NULL DEFAULT 'assets/images/project-placeholder.png',
  `technologies`   VARCHAR(300)    NOT NULL,
  `category`       VARCHAR(80)     NOT NULL DEFAULT 'Web',
  `project_url`    VARCHAR(500)             DEFAULT NULL,
  `github_url`     VARCHAR(500)             DEFAULT NULL,
  `is_featured`    TINYINT(1)      NOT NULL DEFAULT 0,
  `sort_order`     INT UNSIGNED    NOT NULL DEFAULT 0,
  `created_at`     TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample projects (placeholder — replace with real ones later)
INSERT INTO `projects`
  (`title`, `description`, `image_url`, `technologies`, `category`, `project_url`, `github_url`, `is_featured`, `sort_order`)
VALUES
(
  'E-Ticaret Platformu',
  'Kullanıcı kaydı, ürün yönetimi ve ödeme entegrasyonu içeren tam kapsamlı bir e-ticaret web uygulaması.',
  'https://placehold.co/600x340/0d1530/3b82f6?text=Project',
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
  'https://placehold.co/600x340/0d1530/3b82f6?text=Project',
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
  'https://placehold.co/600x340/0d1530/3b82f6?text=Project',
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
  'https://placehold.co/600x340/0d1530/3b82f6?text=Project',
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
-- MIGRATION: Add EN columns to existing installs
-- Run this if you already have the projects table:
-- ALTER TABLE `projects`
--   ADD COLUMN `title_en`       VARCHAR(150) NOT NULL DEFAULT '' AFTER `title`,
--   ADD COLUMN `description_en` TEXT         NOT NULL AFTER `description`;
-- ============================================================
-- END OF FILE
-- ============================================================

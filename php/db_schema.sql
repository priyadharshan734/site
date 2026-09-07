-- =============================================================================
-- Forthright & Oak — database schema
-- Run: mysql -u root -p < db_schema.sql
-- =============================================================================

CREATE DATABASE IF NOT EXISTS forthright_oak
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE forthright_oak;

-- ---------------------------------------------------------------------------
-- Dedicated application user (least privilege — no DDL rights at runtime)
-- ---------------------------------------------------------------------------
CREATE USER IF NOT EXISTS 'forthright_app'@'localhost' IDENTIFIED BY 'change-me';
GRANT SELECT, INSERT, UPDATE, DELETE ON forthright_oak.* TO 'forthright_app'@'localhost';
FLUSH PRIVILEGES;

-- ---------------------------------------------------------------------------
-- Services offered — backs the three service pages and homepage cards
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  slug          VARCHAR(60)  NOT NULL UNIQUE,          -- e.g. 'home-building'
  name          VARCHAR(120) NOT NULL,
  summary       VARCHAR(280) NOT NULL,
  display_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
  is_active     TINYINT(1) NOT NULL DEFAULT 1,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------------
-- Completed projects — powers the homepage/gallery, filterable by category
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title         VARCHAR(150) NOT NULL,
  category      ENUM('home-building','interior-design','exterior-work') NOT NULL,
  location      VARCHAR(120) NOT NULL,
  description   TEXT,
  image_url     VARCHAR(500) NOT NULL,
  sq_ft         INT UNSIGNED,
  completed_on  DATE,
  is_featured   TINYINT(1) NOT NULL DEFAULT 0,
  display_order TINYINT UNSIGNED NOT NULL DEFAULT 0,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_category (category),
  INDEX idx_featured (is_featured)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------------
-- Client testimonials
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS testimonials (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_name  VARCHAR(120) NOT NULL,
  project_id   INT UNSIGNED NULL,
  quote        TEXT NOT NULL,
  rating       TINYINT UNSIGNED NOT NULL DEFAULT 5,
  is_published TINYINT(1) NOT NULL DEFAULT 1,
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------------
-- Inbound contact-form submissions
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS messages (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name         VARCHAR(120) NOT NULL,
  email        VARCHAR(190) NOT NULL,
  phone        VARCHAR(40)  NOT NULL,
  service      VARCHAR(60)  NULL,
  message      TEXT NOT NULL,
  ip_address   VARCHAR(45),
  status       ENUM('new','contacted','archived') NOT NULL DEFAULT 'new',
  created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_status (status)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------------
-- Admin accounts — used by /admin to view leads and manage content.
-- Passwords are bcrypt hashes (PHP password_hash), never plaintext.
-- Seed no rows here; create your first admin with php/create_admin_cli.php
-- so a real password never sits in version control.
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admin_users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(120) NOT NULL,
  email         VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  last_login_at DATETIME NULL,
  created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------------
-- Seed data
-- ---------------------------------------------------------------------------
INSERT INTO services (slug, name, summary, display_order) VALUES
  ('home-building',   'Home Building',    'Ground-up construction, from foundation to final walkthrough.', 1),
  ('interior-design', 'Interior Design',  'Space planning, materials, and furnishing that fit how you live.', 2),
  ('exterior-work',   'Exterior Work',    'Decks, landscaping, siding, and outdoor living structures.', 3)
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO projects (title, category, location, description, image_url, sq_ft, completed_on, is_featured, display_order) VALUES
  ('Hollow Creek Residence', 'home-building', 'Hollow Creek, VT', 'A four-bedroom timber-frame build set into a sloped, wooded lot.', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1200&auto=format&fit=crop', 3200, '2025-11-02', 1, 1),
  ('Birchwood Kitchen & Living', 'interior-design', 'Birchwood, MA', 'Full interior renovation opening the kitchen into a double-height living space.', 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=1200&auto=format&fit=crop', 1450, '2025-09-14', 1, 2),
  ('Ridgeline Deck & Pergola', 'exterior-work', 'Ridgeline, CO', 'Cedar deck, cable railing, and a cantilevered pergola with integrated lighting.', 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1200&auto=format&fit=crop', 640, '2025-07-30', 1, 3),
  ('Alder Street Addition', 'home-building', 'Alder Street, OR', 'A 900 sq ft second-story addition matching the home''s original 1920s massing.', 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=1200&auto=format&fit=crop', 900, '2025-05-19', 0, 4),
  ('Maple Loft Study', 'interior-design', 'Maple Loft, NY', 'Built-in millwork and a reading nook carved from an underused stair landing.', 'https://images.unsplash.com/photo-1615529182904-14819c35db37?q=80&w=1200&auto=format&fit=crop', 210, '2025-03-11', 0, 5),
  ('Cedar Point Landscape', 'exterior-work', 'Cedar Point, WA', 'Full-lot regrading, drainage correction, and native-planting landscape design.', 'https://images.unsplash.com/photo-1600585152220-90363fe7e115?q=80&w=1200&auto=format&fit=crop', 12000, '2024-12-02', 0, 6)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO testimonials (client_name, project_id, quote, rating) VALUES
  ('J. & M. Alvarez', 1, 'They kept us informed at every framing milestone and the final walkthrough had zero surprises.', 5),
  ('Priya Nandakumar', 2, 'Our kitchen finally works the way we actually cook. The crew respected our home and our timeline.', 5),
  ('Tom Reyes', 3, 'The deck has held up through two hard winters without a single call-back needed.', 5)
ON DUPLICATE KEY UPDATE quote = VALUES(quote);

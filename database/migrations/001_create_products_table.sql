-- =============================================================
--  Migration 001 — Products Table
--  Coffee Export B2B
-- =============================================================

CREATE DATABASE IF NOT EXISTS coffee_export_b2b
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE coffee_export_b2b;

CREATE TABLE IF NOT EXISTS products (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    -- Identity
    name          VARCHAR(120)  NOT NULL,
    slug          VARCHAR(140)  NOT NULL UNIQUE,
    category      ENUM('green', 'roasted') NOT NULL DEFAULT 'green',

    -- Origin & Processing
    origin        VARCHAR(100)  NOT NULL COMMENT 'e.g. Sumatra Mandheling',
    region        VARCHAR(100)  NULL,
    altitude_masl SMALLINT UNSIGNED NULL COMMENT 'Metres above sea level',
    process       ENUM('washed','natural','honey','wet-hulled','anaerobic') NOT NULL DEFAULT 'washed',
    harvest_period VARCHAR(60)  NULL COMMENT 'e.g. April – June',

    -- Technical Specs (Green)
    grade         VARCHAR(40)   NULL COMMENT 'e.g. Grade 1 Specialty, G2 Commercial',
    screen_size   VARCHAR(40)   NULL COMMENT 'e.g. 17/18',
    moisture_pct  DECIMAL(4,1)  NULL COMMENT 'Green bean moisture %',
    defect_count  TINYINT       NULL COMMENT 'Defects per 300g sample',

    -- Technical Specs (Roasted)
    roast_level   ENUM('light','medium-light','medium','medium-dark','dark') NULL,
    roast_profile VARCHAR(120)  NULL,

    -- Taste & Marketing
    flavor_notes  VARCHAR(255)  NULL COMMENT 'Comma-separated cupping notes',
    cupping_score DECIMAL(4,1)  NULL,
    description   TEXT          NULL,

    -- Wholesale Pricing
    price_per_kg  DECIMAL(8,2)  NOT NULL DEFAULT 0.00,
    currency      CHAR(3)       NOT NULL DEFAULT 'USD',
    moq_kg        INT UNSIGNED  NOT NULL DEFAULT 500  COMMENT 'Minimum Order Quantity in kg',
    lead_days     TINYINT       NOT NULL DEFAULT 14   COMMENT 'Lead time in days',

    -- Media
    image_path    VARCHAR(255)  NULL DEFAULT 'images/products/default.jpg',
    badge         VARCHAR(60)   NULL COMMENT 'e.g. Best Seller, Organic, New',

    -- Flags
    featured      TINYINT(1)    NOT NULL DEFAULT 0,
    active        TINYINT(1)    NOT NULL DEFAULT 1,

    created_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_category (category),
    INDEX idx_featured  (featured),
    INDEX idx_active    (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

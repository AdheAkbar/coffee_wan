-- =============================================================
--  Migration 002 — Testimonials Table
--  Coffee Export B2B
-- =============================================================

USE coffee_export_b2b;

CREATE TABLE IF NOT EXISTS testimonials (
    id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    -- Client Info
    client_name       VARCHAR(100) NOT NULL,
    client_title      VARCHAR(120) NULL  COMMENT 'e.g. Head of Procurement',
    company_name      VARCHAR(120) NOT NULL,
    company_country   VARCHAR(80)  NULL,
    company_logo_path VARCHAR(255) NULL  DEFAULT 'images/partners/default-logo.svg',

    -- Review
    quote             TEXT         NOT NULL,
    rating            TINYINT      NOT NULL DEFAULT 5 COMMENT '1-5 star rating',

    -- Partnership details shown on card
    partnership_since YEAR         NULL,
    volume_per_year   VARCHAR(60)  NULL COMMENT 'e.g. 120 MT/year',

    -- Flags
    active            TINYINT(1)   NOT NULL DEFAULT 1,
    sort_order        TINYINT      NOT NULL DEFAULT 0,

    created_at        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_active_sort (active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

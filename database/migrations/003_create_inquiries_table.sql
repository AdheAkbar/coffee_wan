-- =============================================================
--  Migration 003 — Wholesale Inquiries Table
--  Coffee Export B2B
-- =============================================================

USE coffee_export_b2b;

CREATE TABLE IF NOT EXISTS inquiries (
    id                 INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    -- Company
    company_name       VARCHAR(150) NOT NULL,
    company_website    VARCHAR(255) NULL,
    company_country    VARCHAR(80)  NOT NULL,
    company_type       ENUM(
                           'importer', 'roaster', 'distributor',
                           'retailer', 'cafe_chain', 'other'
                       ) NOT NULL DEFAULT 'other',

    -- Contact
    contact_name       VARCHAR(100) NOT NULL,
    contact_title      VARCHAR(100) NULL,
    email              VARCHAR(180) NOT NULL,
    phone              VARCHAR(40)  NULL,

    -- Product Interest
    product_interest   VARCHAR(255) NOT NULL COMMENT 'Comma-separated product IDs or names',
    category_interest  SET('green','roasted') NOT NULL DEFAULT 'green',

    -- Volume & Logistics
    monthly_volume_kg  INT UNSIGNED NULL  COMMENT 'Desired monthly volume in kg',
    target_market      VARCHAR(120) NULL,
    delivery_terms     ENUM('FOB','CIF','EXW','DAP') NULL DEFAULT 'FOB',
    incoterm_port      VARCHAR(120) NULL,

    -- Message
    message            TEXT         NULL,

    -- Internal tracking
    status             ENUM('new','read','replied','closed') NOT NULL DEFAULT 'new',
    assigned_to        VARCHAR(80)  NULL,
    internal_notes     TEXT         NULL,

    -- Metadata
    ip_address         VARCHAR(45)  NULL,
    user_agent         VARCHAR(255) NULL,
    referrer           VARCHAR(255) NULL,
    created_at         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at         TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_status     (status),
    INDEX idx_created_at (created_at),
    INDEX idx_email      (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

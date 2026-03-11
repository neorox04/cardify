-- SQL para criar as tabelas do sistema DBsCard
-- Execute este SQL no TablePlus conectado ao banco 'dbscard'

-- 1. Tabela users (expandida)
CREATE TABLE users (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    email_verified_at timestamp NULL,
    password varchar(255) NOT NULL,
    remember_token varchar(100) NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    phone varchar(20) NULL,
    avatar varchar(255) NULL,
    is_active tinyint(1) NOT NULL DEFAULT '1',
    user_type enum('user','company_admin','super_admin') NOT NULL DEFAULT 'user',
    last_login_at timestamp NULL,
    PRIMARY KEY (id),
    UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabela companies
CREATE TABLE companies (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    slug varchar(255) NOT NULL,
    description text NULL,
    logo varchar(255) NULL,
    website varchar(255) NULL,
    email varchar(255) NULL,
    phone varchar(20) NULL,
    address text NULL,
    is_active tinyint(1) NOT NULL DEFAULT '1',
    settings json NULL,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    UNIQUE KEY companies_slug_unique (slug),
    KEY companies_is_active_index (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabela business_cards
CREATE TABLE business_cards (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    user_id bigint unsigned NOT NULL,
    company_id bigint unsigned NULL,
    title varchar(255) NOT NULL,
    slug varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    position varchar(255) NULL,
    email varchar(255) NULL,
    phone varchar(20) NULL,
    website varchar(255) NULL,
    bio text NULL,
    avatar varchar(255) NULL,
    cover_image varchar(255) NULL,
    custom_fields json NULL,
    social_links json NULL,
    qr_code varchar(255) NULL,
    is_active tinyint(1) NOT NULL DEFAULT '1',
    is_public tinyint(1) NOT NULL DEFAULT '1',
    views_count int unsigned NOT NULL DEFAULT '0',
    theme varchar(50) NOT NULL DEFAULT 'default',
    created_at timestamp NULL,
    updated_at timestamp NULL,
    deleted_at timestamp NULL,
    PRIMARY KEY (id),
    UNIQUE KEY business_cards_slug_unique (slug),
    KEY business_cards_user_id_foreign (user_id),
    KEY business_cards_company_id_foreign (company_id),
    KEY business_cards_is_active_index (is_active),
    KEY business_cards_is_public_index (is_public),
    CONSTRAINT business_cards_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT business_cards_company_id_foreign FOREIGN KEY (company_id) REFERENCES companies (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabela pivot company_user
CREATE TABLE company_user (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    user_id bigint unsigned NOT NULL,
    company_id bigint unsigned NOT NULL,
    role varchar(50) NOT NULL DEFAULT 'member',
    joined_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    created_at timestamp NULL,
    updated_at timestamp NULL,
    PRIMARY KEY (id),
    KEY company_user_user_id_foreign (user_id),
    KEY company_user_company_id_foreign (company_id),
    CONSTRAINT company_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT company_user_company_id_foreign FOREIGN KEY (company_id) REFERENCES companies (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabela migrations (necessária para o Laravel)
CREATE TABLE migrations (
    id int unsigned NOT NULL AUTO_INCREMENT,
    migration varchar(255) NOT NULL,
    batch int NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir registros das migrations executadas
INSERT INTO migrations (migration, batch) VALUES
('0001_01_01_000000_create_users_table', 1),
('0001_01_01_000001_create_cache_table', 1),
('0001_01_01_000002_create_jobs_table', 1),
('2024_12_01_000001_expand_users_table', 1),
('2024_12_01_000002_create_companies_table', 1),
('2024_12_01_000003_create_business_cards_table', 1),
('2024_12_01_000004_create_company_user_pivot_table', 1);

-- 6. Tabelas de cache e jobs (opcionais, mas necessárias para o Laravel)
CREATE TABLE cache (
    `key` varchar(255) NOT NULL,
    value mediumtext NOT NULL,
    expiration int NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cache_locks (
    `key` varchar(255) NOT NULL,
    owner varchar(255) NOT NULL,
    expiration int NOT NULL,
    PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE jobs (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    queue varchar(255) NOT NULL,
    payload longtext NOT NULL,
    attempts tinyint unsigned NOT NULL,
    reserved_at int unsigned NULL,
    available_at int unsigned NOT NULL,
    created_at int unsigned NOT NULL,
    PRIMARY KEY (id),
    KEY jobs_queue_index (queue)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE job_batches (
    id varchar(255) NOT NULL,
    name varchar(255) NOT NULL,
    total_jobs int NOT NULL,
    pending_jobs int NOT NULL,
    failed_jobs int NOT NULL,
    failed_job_ids longtext NOT NULL,
    options mediumtext NULL,
    cancelled_at int NULL,
    created_at int NOT NULL,
    finished_at int NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE failed_jobs (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    uuid varchar(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload longtext NOT NULL,
    exception longtext NOT NULL,
    failed_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY failed_jobs_uuid_unique (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
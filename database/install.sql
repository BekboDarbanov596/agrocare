-- ============================================================
-- AI AGRO CARE — MySQL Install Schema для Timeweb
-- Версия: Production 1.1 (Synced with Controllers)
-- ============================================================
-- Импортировать через: phpMyAdmin → SQL → вставить этот файл
-- Или через консоль: mysql -u cy758696_123 -p cy758696_123 < install.sql
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = '+06:00';

-- ============================================================
-- 1. ПОЛЬЗОВАТЕЛИ
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
    `id`                    INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email`                 VARCHAR(255) NULL UNIQUE,
    `phone`                 VARCHAR(30)  NULL UNIQUE,
    `password_hash`         VARCHAR(255) NOT NULL,
    `role`                  ENUM('farmer','veterinarian','admin') NOT NULL DEFAULT 'farmer',
    `language`              VARCHAR(10)  NOT NULL DEFAULT 'ru',
    `timezone`              VARCHAR(50)  NOT NULL DEFAULT 'Asia/Almaty',
    `notification_settings` JSON         NULL,
    `is_active`             TINYINT(1)  NOT NULL DEFAULT 1,
    `created_at`            DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`            DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_users_email`  (`email`),
    INDEX `idx_users_phone`  (`phone`),
    INDEX `idx_users_role`   (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. ХОЗЯЙСТВА (FARMS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `farms` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name`        VARCHAR(255) NOT NULL,
    `region`      VARCHAR(255) NULL,
    `address`     TEXT         NULL,
    `owner_id`    INT UNSIGNED NOT NULL,
    `is_active`   TINYINT(1)  NOT NULL DEFAULT 1,
    `created_at`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_farms_owner` (`owner_id`),
    CONSTRAINT `fk_farms_owner` FOREIGN KEY (`owner_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. СВЯЗЬ ПОЛЬЗОВАТЕЛЬ ↔ ХОЗЯЙСТВО (USER_FARMS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `user_farms` (
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`   INT UNSIGNED NOT NULL,
    `farm_id`   INT UNSIGNED NOT NULL,
    `role`      ENUM('owner','manager','worker') NOT NULL DEFAULT 'worker',
    `joined_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_user_farm` (`user_id`, `farm_id`),
    INDEX `idx_user_farms_farm` (`farm_id`),
    CONSTRAINT `fk_user_farms_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_farms_farm` FOREIGN KEY (`farm_id`) REFERENCES `farms`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. УЧАСТКИ / ПОЛЯ (FIELDS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `fields` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `farm_id`       INT UNSIGNED NOT NULL,
    `name`          VARCHAR(255) NOT NULL,
    `area_ha`       DECIMAL(10,2) NULL,
    `current_crop`  VARCHAR(255) NULL,
    `soil_type`     VARCHAR(100) NULL,
    `coordinates`   JSON         NULL,
    `notes`         TEXT         NULL,
    `is_active`     TINYINT(1)  NOT NULL DEFAULT 1,
    `created_at`    DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_fields_farm` (`farm_id`),
    CONSTRAINT `fk_fields_farm` FOREIGN KEY (`farm_id`) REFERENCES `farms`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. ЖИВОТНЫЕ (ANIMALS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `animals` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `farm_id`        INT UNSIGNED NOT NULL,
    `user_id`        INT UNSIGNED NOT NULL,
    `name`           VARCHAR(255) NOT NULL,
    `species`        VARCHAR(100) NOT NULL,
    `breed`          VARCHAR(100) NULL,
    `birth_date`     DATE         NULL,
    `gender`         ENUM('male','female','unknown') NOT NULL DEFAULT 'unknown',
    `weight_kg`      DECIMAL(8,2) NULL,
    `tag_number`     VARCHAR(100) NULL,
    `health_status`  ENUM('healthy','sick','treatment','quarantine','dead') NOT NULL DEFAULT 'healthy',
    `notes`          TEXT         NULL,
    `is_active`      TINYINT(1)  NOT NULL DEFAULT 1,
    `created_at`     DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_animals_farm`   (`farm_id`),
    INDEX `idx_animals_user`   (`user_id`),
    INDEX `idx_animals_status` (`health_status`),
    CONSTRAINT `fk_animals_farm` FOREIGN KEY (`farm_id`) REFERENCES `farms`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_animals_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. СЛУЧАИ / ДИАГНОЗЫ ПО ЖИВОТНЫМ (ANIMAL_CASES)
-- ============================================================
CREATE TABLE IF NOT EXISTS `animal_cases` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `farm_id`         INT UNSIGNED NOT NULL,
    `user_id`         INT UNSIGNED NOT NULL,
    `species`         VARCHAR(100) NULL,
    `age_weight`      VARCHAR(100) NULL,
    `temperature`     VARCHAR(50)  NULL,
    `symptoms`        TEXT         NULL,
    `triage_level`    VARCHAR(50)  NULL,
    `recommendations` JSON         NULL,
    `diagnosis`       TEXT         NULL,
    `treatment`       TEXT         NULL,
    `status`          VARCHAR(50)  NOT NULL DEFAULT 'created',
    `created_at`      DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_animal_cases_farm` (`farm_id`),
    INDEX `idx_animal_cases_user` (`user_id`),
    CONSTRAINT `fk_animal_cases_farm` FOREIGN KEY (`farm_id`) REFERENCES `farms`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_animal_cases_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 7. ПРОФИЛИ ВЕТЕРИНАРОВ (VET_PROFILES)
-- ============================================================
CREATE TABLE IF NOT EXISTS `vet_profiles` (
    `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`             INT UNSIGNED NOT NULL UNIQUE,
    `full_name`           VARCHAR(255) NULL,
    `specialization`      JSON         NULL,
    `license_number`      VARCHAR(100) NULL,
    `experience_years`    INT          NULL,
    `bio`                 TEXT         NULL,
    `available_hours`     JSON         NULL,
    `languages`           JSON         NULL,
    `certifications`      JSON         NULL,
    `consultation_price`  DECIMAL(10,2) NULL,
    `photo_uri`           VARCHAR(500) NULL,
    `rating`              DECIMAL(3,2) NULL DEFAULT 0.00,
    `total_consultations` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_verified`         TINYINT(1)  NOT NULL DEFAULT 0,
    `is_available`        TINYINT(1)  NOT NULL DEFAULT 1,
    `created_at`          DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`          DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_vet_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 8. AI СООБЩЕНИЯ (AI_MESSAGES)
-- ============================================================
CREATE TABLE IF NOT EXISTS `ai_messages` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`      INT UNSIGNED NOT NULL,
    `context_type` VARCHAR(50)  NOT NULL DEFAULT 'general',
    `context_id`   INT UNSIGNED NULL,
    `role`         ENUM('user','assistant','system') NOT NULL DEFAULT 'user',
    `content`      LONGTEXT     NOT NULL,
    `created_at`   DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ai_messages_user` (`user_id`),
    CONSTRAINT `fk_ai_messages_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 9. ЧАТ МЕЖДУ ПОЛЬЗОВАТЕЛЯМИ (USER_CHATS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `user_chats` (
    `id`                 INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user1_id`           INT UNSIGNED NOT NULL,
    `user2_id`           INT UNSIGNED NOT NULL,
    `last_message_at`    DATETIME     NULL,
    `last_message_text`  TEXT         NULL,
    `unread_count_user1` INT UNSIGNED NOT NULL DEFAULT 0,
    `unread_count_user2` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at`         DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uk_chat_users` (`user1_id`, `user2_id`),
    INDEX `idx_user_chats_user2` (`user2_id`),
    CONSTRAINT `fk_user_chats_user1` FOREIGN KEY (`user1_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_chats_user2` FOREIGN KEY (`user2_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 10. СООБЩЕНИЯ ЧАТА (USER_MESSAGES)
-- ============================================================
CREATE TABLE IF NOT EXISTS `user_messages` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `chat_id`    INT UNSIGNED NOT NULL,
    `sender_id`  INT UNSIGNED NOT NULL,
    `content`    TEXT         NOT NULL,
    `is_read`    TINYINT(1)   NOT NULL DEFAULT 0,
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_user_messages_chat`   (`chat_id`),
    INDEX `idx_user_messages_sender` (`sender_id`),
    CONSTRAINT `fk_user_messages_chat`   FOREIGN KEY (`chat_id`) REFERENCES `user_chats`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_user_messages_sender` FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 11. АНАЛИЗ ФОТО РАСТЕНИЙ (PLANT_ANALYSES)
-- ============================================================
CREATE TABLE IF NOT EXISTS `plant_analyses` (
    `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `field_id`         INT UNSIGNED NULL,
    `user_id`          INT UNSIGNED NOT NULL,
    `photo_uri`        VARCHAR(500) NOT NULL,
    `crop`             VARCHAR(255) NULL,
    `predictions`      JSON         NULL,
    `recommendations`  JSON         NULL,
    `confidence`       DECIMAL(5,2) NULL,
    `status`           VARCHAR(50)  NOT NULL DEFAULT 'pending',
    `created_at`       DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_plant_analyses_user` (`user_id`),
    INDEX `idx_plant_analyses_field` (`field_id`),
    CONSTRAINT `fk_plant_analyses_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_plant_analyses_field` FOREIGN KEY (`field_id`) REFERENCES `fields`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 12. ПЛАНЫ УЧАСТКОВ (FIELD_PLANS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `field_plans` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `field_id`      INT UNSIGNED NOT NULL,
    `region`        VARCHAR(255) NULL,
    `crop`          VARCHAR(255) NOT NULL,
    `area_hectares` DECIMAL(10,2) NULL,
    `start_date`    DATE         NULL,
    `plan_data`     JSON         NULL,
    `risks`         JSON         NULL,
    `status`        VARCHAR(50)  NOT NULL DEFAULT 'draft',
    `created_by`    INT UNSIGNED NOT NULL,
    `created_at`    DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_field_plans_field` (`field_id`),
    INDEX `idx_field_plans_user`  (`created_by`),
    CONSTRAINT `fk_field_plans_field` FOREIGN KEY (`field_id`) REFERENCES `fields`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_field_plans_user`  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 13. ИСТОРИЯ ПОСЕВОВ (CROP_CYCLES)
-- ============================================================
CREATE TABLE IF NOT EXISTS `crop_cycles` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `field_id`    INT UNSIGNED NOT NULL,
    `crop`        VARCHAR(255) NOT NULL,
    `year`        YEAR         NOT NULL,
    `yield`       DECIMAL(12,2) NULL,
    `notes`       TEXT         NULL,
    `created_at`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_crop_cycles_field` (`field_id`),
    CONSTRAINT `fk_crop_cycles_field` FOREIGN KEY (`field_id`) REFERENCES `fields`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 14. ЛОГИ ДЕЙСТВИЙ (AUDIT_LOG)
-- ============================================================
CREATE TABLE IF NOT EXISTS `audit_log` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`    INT UNSIGNED NULL,
    `action`     VARCHAR(255) NOT NULL,
    `entity`     VARCHAR(100) NULL,
    `entity_id`  INT UNSIGNED NULL,
    `ip_address` VARCHAR(45)  NULL,
    `user_agent` VARCHAR(500) NULL,
    `created_at` DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_audit_log_user`   (`user_id`),
    INDEX `idx_audit_log_action` (`action`),
    INDEX `idx_audit_log_date`   (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 15. ПЛАНИРОВЩИК (PLANNER_TASKS)
-- ============================================================
CREATE TABLE IF NOT EXISTS `planner_tasks` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id`     INT UNSIGNED NOT NULL,
    `title`       VARCHAR(255) NOT NULL,
    `description` TEXT         NULL,
    `task_date`   DATE         NOT NULL,
    `task_type`   VARCHAR(50)  NOT NULL DEFAULT 'manual', -- 'manual', 'ai_recommendation', 'auto_event'
    `status`      ENUM('pending','completed','canceled') NOT NULL DEFAULT 'pending',
    `created_at`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_planner_tasks_user` (`user_id`),
    INDEX `idx_planner_tasks_date` (`task_date`),
    CONSTRAINT `fk_planner_tasks_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE IF NOT EXISTS `contact_submissions` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`         VARCHAR(255) NOT NULL,
  `email`        VARCHAR(255) NOT NULL,
  `project_type` VARCHAR(100) NULL,
  `message`      TEXT NOT NULL,
  `ip`           VARCHAR(45) NULL,
  `user_agent`   VARCHAR(512) NULL,
  `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

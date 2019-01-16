-- MySQL dump 10.13  Distrib 5.6.38, for osx10.9 (x86_64)
--
-- Host: homestead.test    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads`
(
  `id`          int(10) unsigned                        NOT NULL AUTO_INCREMENT,
  `owner_id`    int(10) unsigned                        NOT NULL,
  `category_id` int(10) unsigned                        NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `relevance`   tinyint(1)                              NOT NULL DEFAULT '1',
  `created_at`  timestamp                               NULL     DEFAULT NULL,
  `updated_at`  timestamp                               NULL     DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ads_owner_id_foreign` (`owner_id`),
  CONSTRAINT `ads_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `ads`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories`
(
  `id`         int(10) unsigned                        NOT NULL AUTO_INCREMENT,
  `title`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp                               NULL DEFAULT NULL,
  `updated_at` timestamp                               NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `categories`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations`
(
  `id`        int(10) unsigned                        NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch`     int(11)                                 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 13
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations`
  DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES (1, '2014_10_12_000000_create_users_table', 1),
       (2, '2014_10_12_100000_create_password_resets_table', 1),
       (3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
       (4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
       (5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
       (6, '2016_06_01_000004_create_oauth_clients_table', 1),
       (7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
       (8, '2018_08_08_100000_create_telescope_entries_table', 1),
       (9, '2018_12_20_192451_create_news_table', 1),
       (10, '2018_12_23_145733_create_ads_table', 1),
       (11, '2018_12_29_121702_create_categories_table', 1),
       (12, '2018_12_29_152534_add_foreign_keys', 1);
/*!40000 ALTER TABLE `migrations`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news`
(
  `id`          int(10) unsigned                        NOT NULL AUTO_INCREMENT,
  `owner_id`    int(10) unsigned                        NOT NULL,
  `category_id` int(10) unsigned                        NOT NULL,
  `title`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci         NOT NULL,
  `created_at`  timestamp                               NULL DEFAULT NULL,
  `updated_at`  timestamp                               NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_owner_id_foreign` (`owner_id`),
  CONSTRAINT `news_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `news`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_access_tokens`
(
  `id`         varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id`    int(11)                                      DEFAULT NULL,
  `client_id`  int(10) unsigned                        NOT NULL,
  `name`       varchar(255) COLLATE utf8mb4_unicode_ci      DEFAULT NULL,
  `scopes`     text COLLATE utf8mb4_unicode_ci,
  `revoked`    tinyint(1)                              NOT NULL,
  `created_at` timestamp                               NULL DEFAULT NULL,
  `updated_at` timestamp                               NULL DEFAULT NULL,
  `expires_at` datetime                                     DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_auth_codes`
(
  `id`         varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id`    int(11)                                 NOT NULL,
  `client_id`  int(10) unsigned                        NOT NULL,
  `scopes`     text COLLATE utf8mb4_unicode_ci,
  `revoked`    tinyint(1)                              NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_clients`
(
  `id`                     int(10) unsigned                        NOT NULL AUTO_INCREMENT,
  `user_id`                int(11)                                      DEFAULT NULL,
  `name`                   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret`                 varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect`               text COLLATE utf8mb4_unicode_ci         NOT NULL,
  `personal_access_client` tinyint(1)                              NOT NULL,
  `password_client`        tinyint(1)                              NOT NULL,
  `revoked`                tinyint(1)                              NOT NULL,
  `created_at`             timestamp                               NULL DEFAULT NULL,
  `updated_at`             timestamp                               NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_personal_access_clients`
(
  `id`         int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id`  int(10) unsigned NOT NULL,
  `created_at` timestamp        NULL DEFAULT NULL,
  `updated_at` timestamp        NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_personal_access_clients_client_id_index` (`client_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_personal_access_clients`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oauth_refresh_tokens`
(
  `id`              varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked`         tinyint(1)                              NOT NULL,
  `expires_at`      datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets`
(
  `email`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp                               NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries`
--

DROP TABLE IF EXISTS `telescope_entries`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries`
(
  `sequence`                bigint(20) unsigned                    NOT NULL AUTO_INCREMENT,
  `uuid`                    char(36) COLLATE utf8mb4_unicode_ci    NOT NULL,
  `batch_id`                char(36) COLLATE utf8mb4_unicode_ci    NOT NULL,
  `family_hash`             varchar(255) COLLATE utf8mb4_unicode_ci         DEFAULT NULL,
  `should_display_on_index` tinyint(1)                             NOT NULL DEFAULT '1',
  `type`                    varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content`                 text COLLATE utf8mb4_unicode_ci        NOT NULL,
  `created_at`              datetime                                        DEFAULT NULL,
  PRIMARY KEY (`sequence`),
  UNIQUE KEY `telescope_entries_uuid_unique` (`uuid`),
  KEY `telescope_entries_batch_id_index` (`batch_id`),
  KEY `telescope_entries_type_should_display_on_index_index` (`type`, `should_display_on_index`),
  KEY `telescope_entries_family_hash_index` (`family_hash`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries`
--

LOCK TABLES `telescope_entries` WRITE;
/*!40000 ALTER TABLE `telescope_entries`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_entries_tags`
--

DROP TABLE IF EXISTS `telescope_entries_tags`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_entries_tags`
(
  `entry_uuid` char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
  `tag`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `telescope_entries_tags_entry_uuid_tag_index` (`entry_uuid`, `tag`),
  KEY `telescope_entries_tags_tag_index` (`tag`),
  CONSTRAINT `telescope_entries_tags_entry_uuid_foreign` FOREIGN KEY (`entry_uuid`) REFERENCES `telescope_entries` (`uuid`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_entries_tags`
--

LOCK TABLES `telescope_entries_tags` WRITE;
/*!40000 ALTER TABLE `telescope_entries_tags`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_entries_tags`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `telescope_monitoring`
--

DROP TABLE IF EXISTS `telescope_monitoring`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telescope_monitoring`
(
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telescope_monitoring`
--

LOCK TABLES `telescope_monitoring` WRITE;
/*!40000 ALTER TABLE `telescope_monitoring`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `telescope_monitoring`
  ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users`
(
  `id`                int(10) unsigned                        NOT NULL AUTO_INCREMENT,
  `name`              varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email`             varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp                               NULL DEFAULT NULL,
  `password`          varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token`    varchar(100) COLLATE utf8mb4_unicode_ci      DEFAULT NULL,
  `created_at`        timestamp                               NULL DEFAULT NULL,
  `updated_at`        timestamp                               NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users`
  DISABLE KEYS */;
/*!40000 ALTER TABLE `users`
  ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2019-01-14 20:00:07

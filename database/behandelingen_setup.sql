-- Testdata Kniploket Tiko voor database examen_dag3
-- Complete database setup script - LOWERCASE VERSIE
-- Voer dit script uit in MySQL/phpMyAdmin

CREATE DATABASE IF NOT EXISTS `examen_dag3`;
USE `examen_dag3`;

SET FOREIGN_KEY_CHECKS = 0;

-- Drop alle bestaande tabellen om conflicts te voorkomen
DROP TABLE IF EXISTS `behandeling_product`;
DROP TABLE IF EXISTS `behandeling_per_voorraad`;
DROP TABLE IF EXISTS `medewerker_per_behandeling`;
DROP TABLE IF EXISTS `leverancier_order`;
DROP TABLE IF EXISTS `voorraad`;
DROP TABLE IF EXISTS `product`;
DROP TABLE IF EXISTS `behandeling`;
DROP TABLE IF EXISTS `categorie`;
DROP TABLE IF EXISTS `leverancier`;
DROP TABLE IF EXISTS `medewerker_per_contact`;
DROP TABLE IF EXISTS `medewerker`;
DROP TABLE IF EXISTS `klant_per_contact`;
DROP TABLE IF EXISTS `klant`;
DROP TABLE IF EXISTS `contact`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

-- Maak users tabel aan
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'klant',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak contact tabel aan
CREATE TABLE `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `straatnaam` varchar(100) NOT NULL,
  `huisnummer` varchar(10) NOT NULL,
  `toevoeging` varchar(10) DEFAULT NULL,
  `postcode` varchar(10) NOT NULL,
  `plaats` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobiel` varchar(20) NOT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak klant tabel aan
CREATE TABLE `klant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `tussenvoegsel` varchar(20) DEFAULT NULL,
  `achternaam` varchar(100) NOT NULL,
  `relatienummer` varchar(50) NOT NULL,
  `bijzonderheden` text,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `klant_user_id_foreign` (`user_id`),
  CONSTRAINT `klant_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak klant_per_contact tabel aan
CREATE TABLE `klant_per_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `klant_id` int NOT NULL,
  `contact_id` int NOT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `klant_per_contact_klant_id_foreign` (`klant_id`),
  KEY `klant_per_contact_contact_id_foreign` (`contact_id`),
  CONSTRAINT `klant_per_contact_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE,
  CONSTRAINT `klant_per_contact_klant_id_foreign` FOREIGN KEY (`klant_id`) REFERENCES `klant` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak medewerker tabel aan
CREATE TABLE `medewerker` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `voornaam` varchar(100) NOT NULL,
  `tussenvoegsel` varchar(20) DEFAULT NULL,
  `achternaam` varchar(100) NOT NULL,
  `specialisatie` varchar(100) DEFAULT NULL,
  `geboortedatum` date DEFAULT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medewerker_user_id_foreign` (`user_id`),
  CONSTRAINT `medewerker_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak medewerker_per_contact tabel aan
CREATE TABLE `medewerker_per_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medewerker_id` int NOT NULL,
  `contact_id` int NOT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medewerker_per_contact_medewerker_id_foreign` (`medewerker_id`),
  KEY `medewerker_per_contact_contact_id_foreign` (`contact_id`),
  CONSTRAINT `medewerker_per_contact_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contact` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medewerker_per_contact_medewerker_id_foreign` FOREIGN KEY (`medewerker_id`) REFERENCES `medewerker` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak categorie tabel aan
CREATE TABLE `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `omschrijving` text,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak behandeling tabel aan
CREATE TABLE `behandeling` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(100) NOT NULL,
  `omschrijving` text,
  `duur_minuten` int NOT NULL,
  `prijs` decimal(10,2) NOT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak product tabel aan
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `naam` varchar(255) NOT NULL,
  `omschrijving` text,
  `merk` varchar(100) DEFAULT NULL,
  `ean_code` varchar(50) DEFAULT NULL,
  `houdbaarheidsdatum` date DEFAULT NULL,
  `inkoop_prijs` decimal(10,2) NOT NULL,
  `verkoop_prijs` decimal(10,2) NOT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_categorie_id_foreign` (`categorie_id`),
  CONSTRAINT `product_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak voorraad tabel aan
CREATE TABLE `voorraad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `aantal_op_voorraad` int NOT NULL DEFAULT '0',
  `aantal_uitgegeven` int NOT NULL DEFAULT '0',
  `aantal_bijgekomen` int NOT NULL DEFAULT '0',
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `voorraad_product_id_foreign` (`product_id`),
  CONSTRAINT `voorraad_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak behandeling_product pivot tabel aan (koppeltabel tussen behandeling en product)
CREATE TABLE `behandeling_product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `behandeling_id` int NOT NULL,
  `product_id` int NOT NULL,
  `aantal` int NOT NULL DEFAULT '1',
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `behandeling_product_behandeling_id_foreign` (`behandeling_id`),
  KEY `behandeling_product_product_id_foreign` (`product_id`),
  CONSTRAINT `behandeling_product_behandeling_id_foreign` FOREIGN KEY (`behandeling_id`) REFERENCES `behandeling` (`id`) ON DELETE CASCADE,
  CONSTRAINT `behandeling_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak medewerker_per_behandeling tabel aan
CREATE TABLE `medewerker_per_behandeling` (
  `id` int NOT NULL AUTO_INCREMENT,
  `medewerker_id` int NOT NULL,
  `behandeling_id` int NOT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medewerker_per_behandeling_medewerker_id_foreign` (`medewerker_id`),
  KEY `medewerker_per_behandeling_behandeling_id_foreign` (`behandeling_id`),
  CONSTRAINT `medewerker_per_behandeling_behandeling_id_foreign` FOREIGN KEY (`behandeling_id`) REFERENCES `behandeling` (`id`) ON DELETE CASCADE,
  CONSTRAINT `medewerker_per_behandeling_medewerker_id_foreign` FOREIGN KEY (`medewerker_id`) REFERENCES `medewerker` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak leverancier tabel aan
CREATE TABLE `leverancier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naam` varchar(255) NOT NULL,
  `straatnaam` varchar(100) DEFAULT NULL,
  `huisnummer` varchar(10) DEFAULT NULL,
  `toevoeging` varchar(10) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `plaats` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobiel` varchar(20) DEFAULT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak leverancier_order tabel aan
CREATE TABLE `leverancier_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ordernummer` varchar(50) NOT NULL,
  `product_id` int NOT NULL,
  `leverancier_id` int NOT NULL,
  `aantal` int NOT NULL,
  `orderdatum` date NOT NULL,
  `leverdatum` date DEFAULT NULL,
  `leverstatus` varchar(50) DEFAULT NULL,
  `is_actief` bit(1) DEFAULT b'1',
  `opmerking` varchar(255) DEFAULT NULL,
  `datum_aangemaakt` datetime(6) DEFAULT NULL,
  `datum_gewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leverancier_order_product_id_foreign` (`product_id`),
  KEY `leverancier_order_leverancier_id_foreign` (`leverancier_id`),
  CONSTRAINT `leverancier_order_leverancier_id_foreign` FOREIGN KEY (`leverancier_id`) REFERENCES `leverancier` (`id`) ON DELETE CASCADE,
  CONSTRAINT `leverancier_order_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Laravel systeem tabellen aan
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;


-- ======================================
-- INSERT DATA
-- ======================================

-- Data voor tabel users (wachtwoord voor iedereen: password)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
  (1, 'Salon Eigenaar', 'eigenaar@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'eigenaar', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (2, 'Fatima El Amrani', 'fatima@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (3, 'Sanne de Vries', 'sanne.devries@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (4, 'Mohamed El Idrissi', 'mohamed.elidrissi@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (5, 'Lisa van Dijk', 'lisa.vandijk@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (6, 'Youssef Benali', 'youssef.benali@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (7, 'Noor Bakker', 'noor.bakker@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (8, 'Kevin Smit', 'kevin.smit@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (9, 'Aylin Demir', 'aylin.demir@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (10, 'Tom Verhoeven', 'tom.verhoeven@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (11, 'Romy Jacobs', 'romy.jacobs@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (12, 'Piet van Loenen', 'piet.van.loenen@gmail.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (13, 'Jan Jansen', 'jan.jansen@outlook.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (14, 'Saskia de Boer', 'saskia.deboer@yahoo.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (15, 'Ahmed Mansouri', 'ahmed.mansouri@icloud.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (16, 'Marieke van den Berg', 'marieke.vandenberg@ziggo.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (17, 'Daan Visser', 'daan.visser@live.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  (18, 'Dani Bouzidi', 'danibouzidi7@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eigenaar', NULL, '2026-07-07 12:00:00', '2026-07-07 12:00:00');

-- Data voor tabel contact
INSERT INTO `contact` (`id`, `straatnaam`, `huisnummer`, `toevoeging`, `postcode`, `plaats`, `email`, `mobiel`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 'Kanaalstraat', '12', NULL, '3511AB', 'Utrecht', 'fatima@kniplokettiko.nl', '0612345678', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 'Croeselaan', '101', NULL, '3521BJ', 'Utrecht', 'sanne.devries@kniplokettiko.nl', '0611111111', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 'Amsterdamsestraatweg', '223', NULL, '3551CG', 'Utrecht', 'mohamed.elidrissi@kniplokettiko.nl', '0611111112', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 'Maliebaan', '17', NULL, '3581CC', 'Utrecht', 'lisa.vandijk@kniplokettiko.nl', '0611111113', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 'Balijelaan', '63', NULL, '3521GM', 'Utrecht', 'youssef.benali@kniplokettiko.nl', '0611111114', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 'Nachtegaalstraat', '95', NULL, '3581AE', 'Utrecht', 'noor.bakker@kniplokettiko.nl', '0611111115', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (7, 'Bernardlaan', '7', NULL, '3527GA', 'Utrecht', 'kevin.smit@kniplokettiko.nl', '0611111116', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (8, 'Laan van Nieuw-Guinea', '141', NULL, '3531JE', 'Utrecht', 'aylin.demir@kniplokettiko.nl', '0611111117', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (9, 'Marnixlaan', '205', NULL, '3552HD', 'Utrecht', 'tom.verhoeven@kniplokettiko.nl', '0611111118', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (10, 'Haroekoeplein', '29', NULL, '3531WK', 'Utrecht', 'romy.jacobs@kniplokettiko.nl', '0611111119', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (11, 'Oudegracht', '88', 'A', '3512AB', 'Utrecht', 'piet.van.loenen@gmail.com', '+31 6 1234 61 71', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (12, 'Biltstraat', '44', NULL, '3572BC', 'Utrecht', 'jan.jansen@outlook.com', '+31 6 1234 61 72', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (13, 'Merelstraat', '12', NULL, '3514CN', 'Utrecht', 'saskia.deboer@yahoo.com', '+31 6 1234 61 73', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (14, 'Winkel van Sinkelstraat', '4', NULL, '3511KV', 'Utrecht', 'ahmed.mansouri@icloud.com', '+31 6 1234 61 74', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (15, 'Adelaarstraat', '50', NULL, '3514CH', 'Utrecht', 'marieke.vandenberg@ziggo.nl', '+31 6 1234 61 75', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (16, 'Vleutenseweg', '73', NULL, '3532HA', 'Utrecht', 'daan.visser@live.nl', '+31 6 1234 61 76', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel klant
INSERT INTO `klant` (`id`, `user_id`, `voornaam`, `tussenvoegsel`, `achternaam`, `relatienummer`, `bijzonderheden`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 12, 'Piet', 'van', 'Loenen', 'KL-2026-001', 'Voorkeur voor ochtendafspraken.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 13, 'Jan', NULL, 'Jansen', 'KL-2026-002', 'Allergie voor sterk geparfumeerde producten.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 14, 'Saskia', 'de', 'Boer', 'KL-2026-003', 'Komt elke zes weken.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 15, 'Ahmed', NULL, 'Mansouri', 'KL-2026-004', 'Wil strakke fade.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 16, 'Marieke', 'van den', 'Berg', 'KL-2026-005', 'Gevoelige hoofdhuid.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 17, 'Daan', NULL, 'Visser', 'KL-2026-006', 'Liefst einde middag.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel klant_per_contact
INSERT INTO `klant_per_contact` (`id`, `klant_id`, `contact_id`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 1, 11, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 2, 12, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 3, 13, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 4, 14, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 5, 15, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 6, 16, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel medewerker
INSERT INTO `medewerker` (`id`, `user_id`, `voornaam`, `tussenvoegsel`, `achternaam`, `specialisatie`, `geboortedatum`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 2, 'Fatima', NULL, 'El Amrani', 'Knippen', '1988-04-12', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 3, 'Sanne', 'de', 'Vries', 'Kleuren', '1996-09-25', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 4, 'Mohamed', NULL, 'El Idrissi', 'Extensions', '1992-02-14', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 5, 'Lisa', 'van', 'Dijk', 'Stylen', '1998-07-08', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 6, 'Youssef', NULL, 'Benali', 'Knippen', '1990-11-30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 7, 'Noor', NULL, 'Bakker', 'Kleuren', '1997-05-21', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (7, 8, 'Kevin', NULL, 'Smit', 'Extensions', '2001-03-17', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (8, 9, 'Aylin', NULL, 'Demir', 'Stylen', '1999-12-04', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (9, 10, 'Tom', NULL, 'Verhoeven', 'Knippen', '1995-08-19', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (10, 11, 'Romy', NULL, 'Jacobs', 'Knippen', '2010-01-15', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel medewerker_per_contact
INSERT INTO `medewerker_per_contact` (`id`, `medewerker_id`, `contact_id`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 1, 1, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 2, 2, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 3, 3, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 4, 4, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 5, 5, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 6, 6, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (7, 7, 7, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (8, 8, 8, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (9, 9, 9, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (10, 10, 10, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel categorie
INSERT INTO `categorie` (`id`, `naam`, `omschrijving`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 'Haarverzorging', 'Producten voor wassen en verzorgen.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 'Kleurproducten', 'Producten voor kleurbehandelingen.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 'Styling', 'Producten voor afwerking en styling.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 'Accessoires', 'Accessoires voor verkoop in de salon.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel behandeling
INSERT INTO `behandeling` (`id`, `naam`, `omschrijving`, `duur_minuten`, `prijs`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 'Knippen', 'Haar knippen en eventueel stylen.', 30, 30.00, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 'Combi behandelingen', 'Combinatie van knippen, kleuren en stylen.', 90, 90.00, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 'Kleuren', 'Haar kleuren (diverse technieken).', 60, 60.00, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 'Permanent', 'Permanente omvorming van het haar.', 120, 110.00, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 'Extensions', 'Plaatsen en verzorgen van extensions.', 180, 250.00, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel product
INSERT INTO `product` (`id`, `categorie_id`, `naam`, `omschrijving`, `merk`, `ean_code`, `houdbaarheidsdatum`, `inkoop_prijs`, `verkoop_prijs`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 1, 'Hydrating Shampoo', 'Milde salonshampoo voor dagelijks gebruik.', 'Tiko Care', '0871234500001', '2027-07-01', 6.50, 14.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 1, 'Repair Conditioner', 'Voedende conditioner voor beschadigd haar.', 'Tiko Care', '0871234500002', '2027-10-15', 7.25, 16.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 1, 'Scalp Balance Masker', 'Kalmerend haarmasker voor gevoelige hoofdhuid.', 'Tiko Care', '0871234500003', '2027-05-20', 8.75, 19.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 1, 'Baardolie Cedar', 'Verzorgende olie voor baardbehandelingen.', 'Tiko Beard', '0871234500004', '2027-09-30', 5.75, 12.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 2, 'Color Creme 6.1', 'Professionele asdonkerblonde kleurcreme.', 'Tiko Color', '0871234500005', '2026-12-31', 12.50, 24.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 2, 'Color Creme 7.43', 'Koperblonde salonkleur met warme ondertoon.', 'Tiko Color', '0871234500006', '2027-01-31', 12.75, 25.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (7, 2, 'Developer 6 Procent', 'Oxidatiecreme voor kleurbehandelingen.', 'Tiko Color', '0871234500007', '2027-03-31', 5.95, 11.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (8, 3, 'Matte Styling Clay', 'Matte clay met flexibele hold.', 'Tiko Style', '0871234500008', '2027-08-31', 4.95, 12.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (9, 3, 'Strong Hold Gel', 'Sterke hold styling gel.', 'Tiko Style', '0871234500009', '2027-03-31', 4.25, 9.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (10, 3, 'Heat Protect Spray', 'Beschermende spray voor föhnen en stylen.', 'Tiko Style', '0871234500010', '2027-11-30', 6.10, 15.95, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel voorraad
INSERT INTO `voorraad` (`id`, `product_id`, `aantal_op_voorraad`, `aantal_uitgegeven`, `aantal_bijgekomen`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 1, 25, 5, 30, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 2, 20, 3, 25, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 3, 15, 2, 20, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 4, 30, 8, 40, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 5, 18, 4, 25, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 6, 12, 2, 15, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (7, 7, 40, 10, 50, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (8, 8, 22, 6, 30, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (9, 9, 35, 9, 45, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (10, 10, 28, 7, 35, 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel behandeling_product (koppelt behandelingen aan producten)
INSERT INTO `behandeling_product` (`id`, `behandeling_id`, `product_id`, `aantal`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 1, 1, 1, 1, 'Shampoo voor knippen', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 1, 8, 1, 1, 'Styling clay voor afwerking', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 2, 1, 1, 1, 'Shampoo voor combi', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 2, 5, 1, 1, 'Kleur voor combi', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 2, 9, 1, 1, 'Gel voor afwerking combi', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 3, 5, 1, 1, 'Kleurcreme', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (7, 3, 7, 1, 1, 'Developer', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (8, 4, 1, 1, 1, 'Shampoo voor permanent', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (9, 4, 2, 1, 1, 'Conditioner voor permanent', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (10, 5, 3, 2, 1, 'Masker voor extensions', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (11, 5, 10, 1, 1, 'Heat protect voor extensions', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel medewerker_per_behandeling
INSERT INTO `medewerker_per_behandeling` (`id`, `medewerker_id`, `behandeling_id`, `is_actief`, `opmerking`, `datum_aangemaakt`, `datum_gewijzigd`) VALUES
  (1, 1, 1, 1, 'Fatima doet knippen', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (2, 5, 1, 1, 'Youssef doet ook knippen', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (3, 9, 1, 1, 'Tom doet ook knippen', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (4, 2, 3, 1, 'Sanne doet kleuren', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (5, 6, 3, 1, 'Noor doet ook kleuren', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (6, 3, 5, 1, 'Mohamed doet extensions', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (7, 7, 5, 1, 'Kevin doet ook extensions', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (8, 4, 2, 1, 'Lisa doet combi behandelingen', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  (9, 8, 2, 1, 'Aylin doet ook combi', '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Klaar!
-- Login gegevens:
-- Email: eigenaar@kniplokettiko.nl
-- Wachtwoord: password
-- OF
-- Email: danibouzidi7@gmail.com
-- Wachtwoord: 12345678

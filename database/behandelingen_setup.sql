-- Testdata Kniploket Tiko voor database examen_dag3
-- Complete database setup script
-- Voer dit script uit in MySQL/phpMyAdmin

CREATE DATABASE IF NOT EXISTS `examen_dag3`;
USE `examen_dag3`;

SET FOREIGN_KEY_CHECKS = 0;

-- Drop alle bestaande tabellen om conflicts te voorkomen
DROP TABLE IF EXISTS `behandeling_product`;
DROP TABLE IF EXISTS `behandelingen`;
DROP TABLE IF EXISTS `producten`;
DROP TABLE IF EXISTS `BehandelingPerVoorraad`;
DROP TABLE IF EXISTS `MedewerkerPerBehandeling`;
DROP TABLE IF EXISTS `LeverancierOrder`;
DROP TABLE IF EXISTS `Voorraad`;
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `Behandeling`;
DROP TABLE IF EXISTS `Categorie`;
DROP TABLE IF EXISTS `Leverancier`;
DROP TABLE IF EXISTS `MedewerkerPerContact`;
DROP TABLE IF EXISTS `Medewerker`;
DROP TABLE IF EXISTS `KlantPerContact`;
DROP TABLE IF EXISTS `Klant`;
DROP TABLE IF EXISTS `Contact`;
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
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Contact tabel aan
CREATE TABLE `Contact` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Straatnaam` varchar(100) NOT NULL,
  `Huisnummer` varchar(10) NOT NULL,
  `Toevoeging` varchar(10) DEFAULT NULL,
  `Postcode` varchar(10) NOT NULL,
  `Plaats` varchar(100) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Mobiel` varchar(20) NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Klant tabel aan
CREATE TABLE `Klant` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `UserId` bigint unsigned NOT NULL,
  `Voornaam` varchar(100) NOT NULL,
  `Tussenvoegsel` varchar(20) DEFAULT NULL,
  `Achternaam` varchar(100) NOT NULL,
  `Relatienummer` varchar(50) NOT NULL,
  `Bijzonderheden` text,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `klant_userid_foreign` (`UserId`),
  CONSTRAINT `klant_userid_foreign` FOREIGN KEY (`UserId`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak KlantPerContact tabel aan
CREATE TABLE `KlantPerContact` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `KlantId` int NOT NULL,
  `ContactId` int NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `klantpercontact_klantid_foreign` (`KlantId`),
  KEY `klantpercontact_contactid_foreign` (`ContactId`),
  CONSTRAINT `klantpercontact_contactid_foreign` FOREIGN KEY (`ContactId`) REFERENCES `Contact` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `klantpercontact_klantid_foreign` FOREIGN KEY (`KlantId`) REFERENCES `Klant` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Medewerker tabel aan
CREATE TABLE `Medewerker` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `UserId` bigint unsigned NOT NULL,
  `Voornaam` varchar(100) NOT NULL,
  `Tussenvoegsel` varchar(20) DEFAULT NULL,
  `Achternaam` varchar(100) NOT NULL,
  `Specialisatie` varchar(100) DEFAULT NULL,
  `Geboortedatum` date DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `medewerker_userid_foreign` (`UserId`),
  CONSTRAINT `medewerker_userid_foreign` FOREIGN KEY (`UserId`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak MedewerkerPerContact tabel aan
CREATE TABLE `MedewerkerPerContact` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `MedewerkerId` int NOT NULL,
  `ContactId` int NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `medewerkerpercontact_medewerkerid_foreign` (`MedewerkerId`),
  KEY `medewerkerpercontact_contactid_foreign` (`ContactId`),
  CONSTRAINT `medewerkerpercontact_contactid_foreign` FOREIGN KEY (`ContactId`) REFERENCES `Contact` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `medewerkerpercontact_medewerkerid_foreign` FOREIGN KEY (`MedewerkerId`) REFERENCES `Medewerker` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Categorie tabel aan
CREATE TABLE `Categorie` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Omschrijving` text,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Behandeling tabel aan
CREATE TABLE `Behandeling` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Omschrijving` text,
  `Duurminuten` int NOT NULL,
  `Prijs` decimal(10,2) NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Product tabel aan
CREATE TABLE `Product` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `CategorieId` int DEFAULT NULL,
  `Naam` varchar(255) NOT NULL,
  `Omschrijving` text,
  `Merk` varchar(100) DEFAULT NULL,
  `EANcode` varchar(50) DEFAULT NULL,
  `Houdbaarheidsdatum` date DEFAULT NULL,
  `InkoopPrijs` decimal(10,2) NOT NULL,
  `VerkoopPrijs` decimal(10,2) NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `product_categorieid_foreign` (`CategorieId`),
  CONSTRAINT `product_categorieid_foreign` FOREIGN KEY (`CategorieId`) REFERENCES `Categorie` (`Id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Voorraad tabel aan
CREATE TABLE `Voorraad` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `ProductId` int NOT NULL,
  `AantalOpVoorraad` int NOT NULL DEFAULT '0',
  `Aantaluitgegeven` int NOT NULL DEFAULT '0',
  `Aantalbijgekomen` int NOT NULL DEFAULT '0',
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `voorraad_productid_foreign` (`ProductId`),
  CONSTRAINT `voorraad_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak BehandelingPerVoorraad tabel aan (koppeltabel tussen Behandeling en Voorraad)
CREATE TABLE `BehandelingPerVoorraad` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `BehandelingId` int NOT NULL,
  `VoorraadId` int NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `behandelingpervoorraad_behandelingid_foreign` (`BehandelingId`),
  KEY `behandelingpervoorraad_voorraadid_foreign` (`VoorraadId`),
  CONSTRAINT `behandelingpervoorraad_behandelingid_foreign` FOREIGN KEY (`BehandelingId`) REFERENCES `Behandeling` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `behandelingpervoorraad_voorraadid_foreign` FOREIGN KEY (`VoorraadId`) REFERENCES `Voorraad` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak MedewerkerPerBehandeling tabel aan
CREATE TABLE `MedewerkerPerBehandeling` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `MedewerkerId` int NOT NULL,
  `BehandelingId` int NOT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `medewerkerperbehandeling_medewerkerid_foreign` (`MedewerkerId`),
  KEY `medewerkerperbehandeling_behandelingid_foreign` (`BehandelingId`),
  CONSTRAINT `medewerkerperbehandeling_behandelingid_foreign` FOREIGN KEY (`BehandelingId`) REFERENCES `Behandeling` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `medewerkerperbehandeling_medewerkerid_foreign` FOREIGN KEY (`MedewerkerId`) REFERENCES `Medewerker` (`Id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak Leverancier tabel aan
CREATE TABLE `Leverancier` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Naam` varchar(255) NOT NULL,
  `Straatnaam` varchar(100) DEFAULT NULL,
  `Huisnummer` varchar(10) DEFAULT NULL,
  `Toevoeging` varchar(10) DEFAULT NULL,
  `Postcode` varchar(10) DEFAULT NULL,
  `Plaats` varchar(100) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Mobiel` varchar(20) DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak LeverancierOrder tabel aan
CREATE TABLE `LeverancierOrder` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Ordernummer` varchar(50) NOT NULL,
  `ProductId` int NOT NULL,
  `LeverancierId` int NOT NULL,
  `Aantal` int NOT NULL,
  `Orderdatum` date NOT NULL,
  `Leverdatum` date DEFAULT NULL,
  `Leverstatus` varchar(50) DEFAULT NULL,
  `IsActief` bit(1) DEFAULT b'1',
  `Opmerking` varchar(255) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) DEFAULT NULL,
  `DatumGewijzigd` datetime(6) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `leverancierorder_productid_foreign` (`ProductId`),
  KEY `leverancierorder_leverancierid_foreign` (`LeverancierId`),
  CONSTRAINT `leverancierorder_leverancierid_foreign` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier` (`Id`) ON DELETE CASCADE,
  CONSTRAINT `leverancierorder_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`) ON DELETE CASCADE
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

-- ======================================
-- INSERT DATA
-- ======================================

-- Data voor tabel users
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', 'Salon Eigenaar', 'eigenaar@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'eigenaar', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', 'Fatima El Amrani', 'fatima@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', 'Sanne de Vries', 'sanne.devries@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', 'Mohamed El Idrissi', 'mohamed.elidrissi@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', 'Lisa van Dijk', 'lisa.vandijk@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', 'Youssef Benali', 'youssef.benali@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', 'Noor Bakker', 'noor.bakker@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', 'Kevin Smit', 'kevin.smit@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', 'Aylin Demir', 'aylin.demir@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', 'Tom Verhoeven', 'tom.verhoeven@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('11', 'Romy Jacobs', 'romy.jacobs@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('12', 'Piet van Loenen', 'piet.van.loenen@gmail.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('13', 'Jan Jansen', 'jan.jansen@outlook.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('14', 'Saskia de Boer', 'saskia.deboer@yahoo.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('15', 'Ahmed Mansouri', 'ahmed.mansouri@icloud.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('16', 'Marieke van den Berg', 'marieke.vandenberg@ziggo.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('17', 'Daan Visser', 'daan.visser@live.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Contact
INSERT INTO `Contact` (`Id`, `Straatnaam`, `Huisnummer`, `Toevoeging`, `Postcode`, `Plaats`, `Email`, `Mobiel`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', 'Kanaalstraat', '12', NULL, '3511AB', 'Utrecht', 'fatima@kniplokettiko.nl', '0612345678', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', 'Croeselaan', '101', NULL, '3521BJ', 'Utrecht', 'sanne.devries@kniplokettiko.nl', '0611111111', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', 'Amsterdamsestraatweg', '223', NULL, '3551CG', 'Utrecht', 'mohamed.elidrissi@kniplokettiko.nl', '0611111112', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', 'Maliebaan', '17', NULL, '3581CC', 'Utrecht', 'lisa.vandijk@kniplokettiko.nl', '0611111113', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', 'Balijelaan', '63', NULL, '3521GM', 'Utrecht', 'youssef.benali@kniplokettiko.nl', '0611111114', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', 'Nachtegaalstraat', '95', NULL, '3581AE', 'Utrecht', 'noor.bakker@kniplokettiko.nl', '0611111115', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', 'Bernardlaan', '7', NULL, '3527GA', 'Utrecht', 'kevin.smit@kniplokettiko.nl', '0611111116', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', 'Laan van Nieuw-Guinea', '141', NULL, '3531JE', 'Utrecht', 'aylin.demir@kniplokettiko.nl', '0611111117', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', 'Marnixlaan', '205', NULL, '3552HD', 'Utrecht', 'tom.verhoeven@kniplokettiko.nl', '0611111118', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', 'Haroekoeplein', '29', NULL, '3531WK', 'Utrecht', 'romy.jacobs@kniplokettiko.nl', '0611111119', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('11', 'Oudegracht', '88', 'A', '3512AB', 'Utrecht', 'piet.van.loenen@gmail.com', '+31 6 1234 61 71', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('12', 'Biltstraat', '44', NULL, '3572BC', 'Utrecht', 'jan.jansen@outlook.com', '+31 6 1234 61 72', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('13', 'Merelstraat', '12', NULL, '3514CN', 'Utrecht', 'saskia.deboer@yahoo.com', '+31 6 1234 61 73', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('14', 'Winkel van Sinkelstraat', '4', NULL, '3511KV', 'Utrecht', 'ahmed.mansouri@icloud.com', '+31 6 1234 61 74', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('15', 'Adelaarstraat', '50', NULL, '3514CH', 'Utrecht', 'marieke.vandenberg@ziggo.nl', '+31 6 1234 61 75', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('16', 'Vleutenseweg', '73', NULL, '3532HA', 'Utrecht', 'daan.visser@live.nl', '+31 6 1234 61 76', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Klant
INSERT INTO `Klant` (`Id`, `UserId`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Relatienummer`, `Bijzonderheden`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '12', 'Piet', 'van', 'Loenen', 'KL-2026-001', 'Voorkeur voor ochtendafspraken.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '13', 'Jan', NULL, 'Jansen', 'KL-2026-002', 'Allergie voor sterk geparfumeerde producten.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '14', 'Saskia', 'de', 'Boer', 'KL-2026-003', 'Komt elke zes weken.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '15', 'Ahmed', NULL, 'Mansouri', 'KL-2026-004', 'Wil strakke fade.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '16', 'Marieke', 'van den', 'Berg', 'KL-2026-005', 'Gevoelige hoofdhuid.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '17', 'Daan', NULL, 'Visser', 'KL-2026-006', 'Liefst einde middag.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel KlantPerContact
INSERT INTO `KlantPerContact` (`Id`, `KlantId`, `ContactId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '1', '11', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '2', '12', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '3', '13', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '4', '14', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '5', '15', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '6', '16', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Medewerker
INSERT INTO `Medewerker` (`Id`, `UserId`, `Voornaam`, `Tussenvoegsel`, `Achternaam`, `Specialisatie`, `Geboortedatum`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '2', 'Fatima', NULL, 'El Amrani', 'Knippen', '1988-04-12', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '3', 'Sanne', 'de', 'Vries', 'Kleuren', '1996-09-25', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '4', 'Mohamed', NULL, 'El Idrissi', 'Extensions', '1992-02-14', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '5', 'Lisa', 'van', 'Dijk', 'Stylen', '1998-07-08', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '6', 'Youssef', NULL, 'Benali', 'Knippen', '1990-11-30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '7', 'Noor', NULL, 'Bakker', 'Kleuren', '1997-05-21', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', '8', 'Kevin', NULL, 'Smit', 'Extensions', '2001-03-17', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', '9', 'Aylin', NULL, 'Demir', 'Stylen', '1999-12-04', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', '10', 'Tom', NULL, 'Verhoeven', 'Knippen', '1995-08-19', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', '11', 'Romy', NULL, 'Jacobs', 'Knippen', '2010-01-15', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel MedewerkerPerContact
INSERT INTO `MedewerkerPerContact` (`Id`, `MedewerkerId`, `ContactId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '1', '1', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '2', '2', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '3', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '4', '4', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '5', '5', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '6', '6', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', '7', '7', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', '8', '8', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', '9', '9', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', '10', '10', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Categorie
INSERT INTO `Categorie` (`Id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', 'Haarverzorging', 'Producten voor wassen en verzorgen.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', 'Kleurproducten', 'Producten voor kleurbehandelingen.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', 'Styling', 'Producten voor afwerking en styling.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', 'Accessoires', 'Accessoires voor verkoop in de salon.', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Behandeling
INSERT INTO `Behandeling` (`Id`, `Naam`, `Omschrijving`, `Duurminuten`, `Prijs`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', 'Knippen', 'Haar knippen en eventueel stylen.', '30', '30.00', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', 'Combi behandelingen', 'Combinatie van knippen, kleuren en stylen.', '90', '90.00', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', 'Kleuren', 'Haar kleuren (diverse technieken).', '60', '60.00', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', 'Permanent', 'Permanente omvorming van het haar.', '120', '110.00', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', 'Extensions', 'Plaatsen en verzorgen van extensions.', '180', '250.00', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Product
INSERT INTO `Product` (`Id`, `CategorieId`, `Naam`, `Omschrijving`, `Merk`, `EANcode`, `Houdbaarheidsdatum`, `InkoopPrijs`, `VerkoopPrijs`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '1', 'Hydrating Shampoo', 'Milde salonshampoo voor dagelijks gebruik.', 'Tiko Care', '0871234500001', '2027-07-01', '6.50', '14.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '1', 'Repair Conditioner', 'Voedende conditioner voor beschadigd haar.', 'Tiko Care', '0871234500002', '2027-10-15', '7.25', '16.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '1', 'Scalp Balance Masker', 'Kalmerend haarmasker voor gevoelige hoofdhuid.', 'Tiko Care', '0871234500003', '2027-05-20', '8.75', '19.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '1', 'Baardolie Cedar', 'Verzorgende olie voor baardbehandelingen.', 'Tiko Beard', '0871234500004', '2027-09-30', '5.75', '12.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '2', 'Color Creme 6.1', 'Professionele asdonkerblonde kleurcreme.', 'Tiko Color', '0871234500005', '2026-12-31', '12.50', '24.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '2', 'Color Creme 7.43', 'Koperblonde salonkleur met warme ondertoon.', 'Tiko Color', '0871234500006', '2027-01-31', '12.75', '25.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', '2', 'Developer 6 Procent', 'Oxidatiecreme voor kleurbehandelingen.', 'Tiko Color', '0871234500007', '2027-03-31', '5.95', '11.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', '3', 'Matte Styling Clay', 'Matte clay met flexibele hold.', 'Tiko Style', '0871234500008', '2027-08-31', '4.95', '12.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', '3', 'Strong Hold Gel', 'Sterke hold styling gel.', 'Tiko Style', '0871234500009', '2027-03-31', '4.25', '9.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', '3', 'Heat Protect Spray', 'Beschermende spray voor föhnen en stylen.', 'Tiko Style', '0871234500010', '2027-11-30', '6.10', '15.95', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Voorraad
INSERT INTO `Voorraad` (`Id`, `ProductId`, `AantalOpVoorraad`, `Aantaluitgegeven`, `Aantalbijgekomen`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '1', '40', '0', '40', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '2', '28', '2', '30', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '3', '18', '0', '18', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '4', '20', '0', '20', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '5', '25', '0', '25', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '6', '16', '1', '17', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', '7', '32', '3', '35', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', '8', '22', '0', '22', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', '9', '35', '0', '35', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', '10', '24', '1', '25', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel BehandelingPerVoorraad (koppel behandelingen aan producten via voorraad)
INSERT INTO `BehandelingPerVoorraad` (`Id`, `BehandelingId`, `VoorraadId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '1', '1', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '1', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '2', '1', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '2', '2', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '2', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '3', '2', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', '4', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', '5', '4', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel MedewerkerPerBehandeling
INSERT INTO `MedewerkerPerBehandeling` (`Id`, `MedewerkerId`, `BehandelingId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', '1', '1', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', '1', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', '1', '2', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', '2', '1', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', '2', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', '3', '1', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', '3', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', '4', '1', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', '4', '3', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', '4', '2', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('11', '5', '4', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel Leverancier
INSERT INTO `Leverancier` (`Id`, `Naam`, `Straatnaam`, `Huisnummer`, `Toevoeging`, `Postcode`, `Plaats`, `Email`, `Mobiel`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', 'Van Duuren Haircosmetics', 'Prinses Irenestraat', '12', 'A', '3584AN', 'Utrecht', 'inkoop@vanduurenhaircosmetics.nl', '+31 623456121', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', 'ColorPro Benelux', 'Gibraltarstraat', '234', NULL, '5611AA', 'Eindhoven', 'orders@colorpro-benelux.nl', '+31 623456122', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', 'SalonStyle Supplies', 'Der Kinderenstraat', '456', 'Bis', '3011AB', 'Rotterdam', 'service@salonstylesupplies.nl', '+31 623456123', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', 'BarberCare Nederland', 'Nachtegaalstraat', '233', 'A', '4811AA', 'Breda', 'bestellingen@barbercare-nederland.nl', '+31 623456124', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', 'HairTools Groothandel', 'Bertram Russellstraat', '45', NULL, '8011AB', 'Zwolle', 'contact@hairtools-groothandel.nl', '+31 623456125', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

-- Data voor tabel LeverancierOrder
INSERT INTO `LeverancierOrder` (`Id`, `Ordernummer`, `ProductId`, `LeverancierId`, `Aantal`, `Orderdatum`, `Leverdatum`, `Leverstatus`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
  ('1', 'ORD-2026-1001', '1', '1', '12', '2026-05-04', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('2', 'ORD-2026-1002', '5', '2', '8', '2026-05-05', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('3', 'ORD-2026-1003', '9', '3', '10', '2026-05-06', '2026-05-08', 'Geleverd', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('4', 'ORD-2026-1004', '7', '2', '6', '2026-05-07', NULL, 'Nietleverbaar', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('5', 'ORD-2026-1005', '10', '4', '9', '2026-05-08', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('6', 'ORD-2026-1006', '2', '1', '7', '2026-05-09', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('7', 'ORD-2026-1007', '3', '1', '6', '2026-05-10', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('8', 'ORD-2026-1008', '4', '4', '5', '2026-05-10', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('9', 'ORD-2026-1009', '6', '2', '6', '2026-05-11', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000'),
  ('10', 'ORD-2026-1010', '8', '3', '8', '2026-05-11', NULL, 'Inbehandeling', 1, NULL, '2026-07-02 09:09:30.000000', '2026-07-02 09:09:30.000000');

SET FOREIGN_KEY_CHECKS = 1;

-- Controle: aantal records per geïmporteerde tabel
SELECT 'users' AS tabel, COUNT(*) AS aantal FROM `users`;
SELECT 'Klant' AS tabel, COUNT(*) AS aantal FROM `Klant`;
SELECT 'KlantPerContact' AS tabel, COUNT(*) AS aantal FROM `KlantPerContact`;
SELECT 'Contact' AS tabel, COUNT(*) AS aantal FROM `Contact`;
SELECT 'MedewerkerPerContact' AS tabel, COUNT(*) AS aantal FROM `MedewerkerPerContact`;
SELECT 'Medewerker' AS tabel, COUNT(*) AS aantal FROM `Medewerker`;
SELECT 'Behandeling' AS tabel, COUNT(*) AS aantal FROM `Behandeling`;
SELECT 'BehandelingPerVoorraad' AS tabel, COUNT(*) AS aantal FROM `BehandelingPerVoorraad`;
SELECT 'Voorraad' AS tabel, COUNT(*) AS aantal FROM `Voorraad`;
SELECT 'Product' AS tabel, COUNT(*) AS aantal FROM `Product`;
SELECT 'MedewerkerPerBehandeling' AS tabel, COUNT(*) AS aantal FROM `MedewerkerPerBehandeling`;
SELECT 'Categorie' AS tabel, COUNT(*) AS aantal FROM `Categorie`;
SELECT 'LeverancierOrder' AS tabel, COUNT(*) AS aantal FROM `LeverancierOrder`;
SELECT 'Leverancier' AS tabel, COUNT(*) AS aantal FROM `Leverancier`;

-- SUCCESS! Complete database is aangemaakt met alle tabellen en testdata

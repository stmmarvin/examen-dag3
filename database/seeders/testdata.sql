-- Testdata Kniploket Tiko voor database examen_dag3
-- Gemaakt uit aangeleverde tekst. Voer dit script uit in MySQL/phpMyAdmin.

USE `examen_dag3`;
SET FOREIGN_KEY_CHECKS = 0;

-- Compatibele manier om systeemvelden alleen toe te voegen als ze nog niet bestaan
DELIMITER $$
DROP PROCEDURE IF EXISTS add_column_if_not_exists $$
CREATE PROCEDURE add_column_if_not_exists(IN p_table VARCHAR(64), IN p_column VARCHAR(64), IN p_definition TEXT)
BEGIN
  IF NOT EXISTS (
    SELECT 1 FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = p_table
      AND COLUMN_NAME = p_column
  ) THEN
    SET @sql = CONCAT('ALTER TABLE `', REPLACE(DATABASE(), '`', '``'), '`.`', REPLACE(p_table, '`', '``'), '` ADD COLUMN `', REPLACE(p_column, '`', '``'), '` ', p_definition);
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
  END IF;
END $$
DELIMITER ;

CALL add_column_if_not_exists('users', 'IsActief', 'BIT DEFAULT b''1''');
CALL add_column_if_not_exists('users', 'Opmerking', 'VARCHAR(255) NULL');
CALL add_column_if_not_exists('users', 'DatumAangemaakt', 'DATETIME(6) NULL');
CALL add_column_if_not_exists('users', 'DatumGewijzigd', 'DATETIME(6) NULL');

-- Maak ontbrekende tabellen aan
CREATE TABLE IF NOT EXISTS `Klant` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `UserId` BIGINT UNSIGNED NULL,
  `Voornaam` VARCHAR(255) NOT NULL,
  `Tussenvoegsel` VARCHAR(50) NULL,
  `Achternaam` VARCHAR(255) NOT NULL,
  `Relatienummer` VARCHAR(50) NULL,
  `Bijzonderheden` TEXT NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`UserId`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `Contact` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `Straatnaam` VARCHAR(255) NULL,
  `Huisnummer` VARCHAR(10) NULL,
  `Toevoeging` VARCHAR(10) NULL,
  `Postcode` VARCHAR(10) NULL,
  `Plaats` VARCHAR(100) NULL,
  `Email` VARCHAR(255) NULL,
  `Mobiel` VARCHAR(20) NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL
);

CREATE TABLE IF NOT EXISTS `KlantPerContact` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `KlantId` INT NOT NULL,
  `ContactId` INT NOT NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`KlantId`) REFERENCES `Klant`(`Id`) ON DELETE CASCADE,
  FOREIGN KEY (`ContactId`) REFERENCES `Contact`(`Id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Medewerker` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `UserId` BIGINT UNSIGNED NULL,
  `Voornaam` VARCHAR(255) NOT NULL,
  `Tussenvoegsel` VARCHAR(50) NULL,
  `Achternaam` VARCHAR(255) NOT NULL,
  `Specialisatie` VARCHAR(255) NULL,
  `Geboortedatum` DATE NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`UserId`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `MedewerkerPerContact` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `MedewerkerId` INT NOT NULL,
  `ContactId` INT NOT NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`MedewerkerId`) REFERENCES `Medewerker`(`Id`) ON DELETE CASCADE,
  FOREIGN KEY (`ContactId`) REFERENCES `Contact`(`Id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Behandeling` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `Naam` VARCHAR(255) NOT NULL,
  `Omschrijving` TEXT NULL,
  `Duurminuten` INT NOT NULL,
  `Prijs` DECIMAL(10,2) NOT NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL
);

CREATE TABLE IF NOT EXISTS `Categorie` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `Naam` VARCHAR(255) NOT NULL,
  `Omschrijving` TEXT NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL
);

CREATE TABLE IF NOT EXISTS `Product` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `CategorieId` INT NULL,
  `Naam` VARCHAR(255) NOT NULL,
  `Omschrijving` TEXT NULL,
  `Merk` VARCHAR(255) NULL,
  `EANcode` VARCHAR(50) NULL,
  `Houdbaarheidsdatum` DATE NULL,
  `InkoopPrijs` DECIMAL(10,2) NULL,
  `VerkoopPrijs` DECIMAL(10,2) NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`CategorieId`) REFERENCES `Categorie`(`Id`) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS `Voorraad` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `ProductId` INT NOT NULL,
  `AantalOpVoorraad` INT NOT NULL DEFAULT 0,
  `Aantaluitgegeven` INT NOT NULL DEFAULT 0,
  `Aantalbijgekomen` INT NOT NULL DEFAULT 0,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`ProductId`) REFERENCES `Product`(`Id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `BehandelingPerVoorraad` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `BehandelingId` INT NOT NULL,
  `VoorraadId` INT NOT NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`BehandelingId`) REFERENCES `Behandeling`(`Id`) ON DELETE CASCADE,
  FOREIGN KEY (`VoorraadId`) REFERENCES `Voorraad`(`Id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `MedewerkerPerBehandeling` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `MedewerkerId` INT NOT NULL,
  `BehandelingId` INT NOT NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`MedewerkerId`) REFERENCES `Medewerker`(`Id`) ON DELETE CASCADE,
  FOREIGN KEY (`BehandelingId`) REFERENCES `Behandeling`(`Id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `Leverancier` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `Naam` VARCHAR(255) NOT NULL,
  `Straatnaam` VARCHAR(255) NULL,
  `Huisnummer` VARCHAR(10) NULL,
  `Toevoeging` VARCHAR(10) NULL,
  `Postcode` VARCHAR(10) NULL,
  `Plaats` VARCHAR(100) NULL,
  `Email` VARCHAR(255) NULL,
  `Mobiel` VARCHAR(20) NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL
);

CREATE TABLE IF NOT EXISTS `LeverancierOrder` (
  `Id` INT PRIMARY KEY AUTO_INCREMENT,
  `Ordernummer` VARCHAR(50) NOT NULL,
  `ProductId` INT NOT NULL,
  `LeverancierId` INT NOT NULL,
  `Aantal` INT NOT NULL,
  `Orderdatum` DATE NOT NULL,
  `Leverdatum` DATE NULL,
  `Leverstatus` VARCHAR(50) NULL,
  `IsActief` BIT DEFAULT b'1',
  `Opmerking` VARCHAR(255) NULL,
  `DatumAangemaakt` DATETIME(6) NULL,
  `DatumGewijzigd` DATETIME(6) NULL,
  FOREIGN KEY (`ProductId`) REFERENCES `Product`(`Id`) ON DELETE CASCADE,
  FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier`(`Id`) ON DELETE CASCADE
);

DROP PROCEDURE IF EXISTS add_column_if_not_exists;

-- Data voor tabel users
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `rolename`, `remember_token`, `created_at`, `updated_at`) VALUES
  ('1', 'Salon Eigenaar', 'eigenaar@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'eigenaar', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('2', 'Fatima El Amrani', 'fatima@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('3', 'Sanne de Vries', 'sanne.devries@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('4', 'Mohamed El Idrissi', 'mohamed.elidrissi@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('5', 'Lisa van Dijk', 'lisa.vandijk@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('6', 'Youssef Benali', 'youssef.benali@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('7', 'Noor Bakker', 'noor.bakker@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('8', 'Kevin Smit', 'kevin.smit@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('9', 'Aylin Demir', 'aylin.demir@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('10', 'Tom Verhoeven', 'tom.verhoeven@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('11', 'Romy Jacobs', 'romy.jacobs@kniplokettiko.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'medewerker', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('12', 'Piet van Loenen', 'piet.van.loenen@gmail.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('13', 'Jan Jansen', 'jan.jansen@outlook.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('14', 'Saskia de Boer', 'saskia.deboer@yahoo.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('15', 'Ahmed Mansouri', 'ahmed.mansouri@icloud.com', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('16', 'Marieke van den Berg', 'marieke.vandenberg@ziggo.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30'),
  ('17', 'Daan Visser', 'daan.visser@live.nl', NULL, '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'klant', NULL, '2026-07-02 09:09:30', '2026-07-02 09:09:30')
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `email` = VALUES(`email`);

SET FOREIGN_KEY_CHECKS = 1;

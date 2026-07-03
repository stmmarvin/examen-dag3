-- SQL script voor Behandelingen feature (User Stories 5 & 6)
-- Kniploket Tiko - Behandelingen en Producten

USE `examen_dag3`;

-- Maak behandelingen tabel aan (als deze nog niet bestaat)
CREATE TABLE IF NOT EXISTS `behandelingen` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `beschrijving` TEXT NULL,
  `duur` INT NOT NULL COMMENT 'Duur in minuten',
  `prijs` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak producten tabel aan (als deze nog niet bestaat)
CREATE TABLE IF NOT EXISTS `producten` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `naam` VARCHAR(255) NOT NULL,
  `beschrijving` TEXT NULL,
  `prijs` DECIMAL(10,2) NOT NULL COMMENT 'Verkoopprijs',
  `voorraad` INT NOT NULL DEFAULT 0,
  `sku` VARCHAR(50) NULL COMMENT 'EAN code',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Maak pivot/koppel tabel tussen behandelingen en producten
CREATE TABLE IF NOT EXISTS `behandeling_product` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `behandeling_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `aantal` INT NOT NULL DEFAULT 1 COMMENT 'Aantal producten benodigd voor deze behandeling',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  FOREIGN KEY (`behandeling_id`) REFERENCES `behandelingen`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `producten`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Voeg test data toe
INSERT INTO `behandelingen` (`naam`, `beschrijving`, `duur`, `prijs`, `created_at`, `updated_at`) VALUES
  ('Combi behandelingen', 'Combinatie van knippen, kleuren en stylen.', 90, 75.00, NOW(), NOW()),
  ('Extensions', 'Plaatsen en verzorgen van extensions.', 180, 120.00, NOW(), NOW()),
  ('Kleuren', 'Haar kleuren (diverse technieken).', 60, 45.00, NOW(), NOW()),
  ('Knippen', 'Haar knippen en eventueel stylen.', 30, 25.00, NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  `naam` = VALUES(`naam`),
  `beschrijving` = VALUES(`beschrijving`),
  `duur` = VALUES(`duur`),
  `prijs` = VALUES(`prijs`),
  `updated_at` = NOW();

-- Voeg producten toe
INSERT INTO `producten` (`naam`, `beschrijving`, `prijs`, `voorraad`, `sku`, `created_at`, `updated_at`) VALUES
  ('Hydrating Shampoo', 'Milde salonshampoo voor dagelijks gebruik.', 14.40, 40, '0871234500001', NOW(), NOW()),
  ('Repair Conditioner', 'Voedende conditioner voor beschadigd haar.', 16.80, 28, '0871234500002', NOW(), NOW()),
  ('Scalp Balance Masker', 'Kalmerend haarmasker voor gevoelige hoofdhuid.', 19.50, 18, '0871234500003', NOW(), NOW())
ON DUPLICATE KEY UPDATE 
  `naam` = VALUES(`naam`),
  `beschrijving` = VALUES(`beschrijving`),
  `prijs` = VALUES(`prijs`),
  `voorraad` = VALUES(`voorraad`),
  `sku` = VALUES(`sku`),
  `updated_at` = NOW();

-- Koppel producten aan behandelingen
-- Combi behandelingen gebruikt 3 producten
INSERT INTO `behandeling_product` (`behandeling_id`, `product_id`, `aantal`, `created_at`, `updated_at`) 
SELECT 1, 1, 1, NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM `behandeling_product` WHERE `behandeling_id` = 1 AND `product_id` = 1);

INSERT INTO `behandeling_product` (`behandeling_id`, `product_id`, `aantal`, `created_at`, `updated_at`) 
SELECT 1, 2, 1, NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM `behandeling_product` WHERE `behandeling_id` = 1 AND `product_id` = 2);

INSERT INTO `behandeling_product` (`behandeling_id`, `product_id`, `aantal`, `created_at`, `updated_at`) 
SELECT 1, 3, 1, NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM `behandeling_product` WHERE `behandeling_id` = 1 AND `product_id` = 3);

-- Extensions gebruikt 1 product
INSERT INTO `behandeling_product` (`behandeling_id`, `product_id`, `aantal`, `created_at`, `updated_at`) 
SELECT 2, 2, 1, NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM `behandeling_product` WHERE `behandeling_id` = 2 AND `product_id` = 2);

-- Kleuren gebruikt 1 product
INSERT INTO `behandeling_product` (`behandeling_id`, `product_id`, `aantal`, `created_at`, `updated_at`) 
SELECT 3, 1, 1, NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM `behandeling_product` WHERE `behandeling_id` = 3 AND `product_id` = 1);

-- Knippen gebruikt 2 producten
INSERT INTO `behandeling_product` (`behandeling_id`, `product_id`, `aantal`, `created_at`, `updated_at`) 
SELECT 4, 1, 1, NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM `behandeling_product` WHERE `behandeling_id` = 4 AND `product_id` = 1);

INSERT INTO `behandeling_product` (`behandeling_id`, `product_id`, `aantal`, `created_at`, `updated_at`) 
SELECT 4, 3, 2, NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM `behandeling_product` WHERE `behandeling_id` = 4 AND `product_id` = 3);

-- Controle: toon aantal records
SELECT 'Behandelingen' AS tabel, COUNT(*) AS aantal FROM `behandelingen`;
SELECT 'Producten' AS tabel, COUNT(*) AS aantal FROM `producten`;
SELECT 'Behandeling_Product' AS tabel, COUNT(*) AS aantal FROM `behandeling_product`;

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KniploketSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // Drop oude Laravel tabellen
        DB::statement('DROP TABLE IF EXISTS `accounts`');
        DB::statement('DROP TABLE IF EXISTS `beschikbaarheden`');
        DB::statement('DROP TABLE IF EXISTS `medewerkers`');
        DB::statement('DROP TABLE IF EXISTS `klanten`');
        DB::statement('DROP TABLE IF EXISTS `afspraken`');
        DB::statement('DROP TABLE IF EXISTS `behandelingen`');
        DB::statement('DROP TABLE IF EXISTS `producten`');
        DB::statement('DROP TABLE IF EXISTS `bestelling_regels`');
        DB::statement('DROP TABLE IF EXISTS `bestellingen`');

        // Maak nieuwe tabellen aan
        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
            CREATE TABLE IF NOT EXISTS `Account` (
              `Id` INT PRIMARY KEY AUTO_INCREMENT,
              `UserId` BIGINT UNSIGNED NULL,
              `Gebruikersnaam` VARCHAR(255) NOT NULL,
              `Email` VARCHAR(255) NOT NULL,
              `Wachtwoord` VARCHAR(255) NOT NULL,
              `Rol` VARCHAR(50) NOT NULL,
              `IsActief` BIT DEFAULT b'1',
              `Opmerking` VARCHAR(255) NULL,
              `DatumAangemaakt` DATETIME(6) NULL,
              `DatumGewijzigd` DATETIME(6) NULL,
              FOREIGN KEY (`UserId`) REFERENCES `users`(`id`) ON DELETE SET NULL
            );
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
            CREATE TABLE IF NOT EXISTS `Beschikbaarheid` (
              `Id` INT PRIMARY KEY AUTO_INCREMENT,
              `MedewerkerId` INT NOT NULL,
              `Dag` VARCHAR(20) NOT NULL,
              `StartTijd` TIME NOT NULL,
              `EindTijd` TIME NOT NULL,
              `IsBeschikbaar` BIT DEFAULT b'1',
              `IsActief` BIT DEFAULT b'1',
              `Opmerking` VARCHAR(255) NULL,
              `DatumAangemaakt` DATETIME(6) NULL,
              `DatumGewijzigd` DATETIME(6) NULL,
              FOREIGN KEY (`MedewerkerId`) REFERENCES `Medewerker`(`Id`) ON DELETE CASCADE
            );
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
            CREATE TABLE IF NOT EXISTS `Afspraak` (
              `Id` INT PRIMARY KEY AUTO_INCREMENT,
              `KlantId` INT NOT NULL,
              `MedewerkerId` INT NOT NULL,
              `BehandelingId` INT NOT NULL,
              `DatumTijd` DATETIME(6) NOT NULL,
              `Status` VARCHAR(50) NOT NULL,
              `IsActief` BIT DEFAULT b'1',
              `Opmerking` VARCHAR(255) NULL,
              `DatumAangemaakt` DATETIME(6) NULL,
              `DatumGewijzigd` DATETIME(6) NULL,
              FOREIGN KEY (`KlantId`) REFERENCES `Klant`(`Id`) ON DELETE CASCADE,
              FOREIGN KEY (`MedewerkerId`) REFERENCES `Medewerker`(`Id`) ON DELETE CASCADE,
              FOREIGN KEY (`BehandelingId`) REFERENCES `Behandeling`(`Id`) ON DELETE CASCADE
            );
        ");

        DB::unprepared("
            CREATE TABLE IF NOT EXISTS `Categorie` (
              `Id` INT PRIMARY KEY AUTO_INCREMENT,
              `Naam` VARCHAR(255) NOT NULL,
              `Omschrijving` TEXT NULL,
              `IsActief` BIT DEFAULT b'1',
              `Opmerking` VARCHAR(255) NULL,
              `DatumAangemaakt` DATETIME(6) NULL,
              `DatumGewijzigd` DATETIME(6) NULL
            );
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        DB::unprepared("
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
        ");

        // Insert testdata - Users
        $users = [
            ['id' => 1, 'name' => 'Salon Eigenaar', 'email' => 'eigenaar@kniplokettiko.nl', 'rolename' => 'eigenaar'],
            ['id' => 2, 'name' => 'Fatima El Amrani', 'email' => 'fatima@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 3, 'name' => 'Sanne de Vries', 'email' => 'sanne.devries@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 4, 'name' => 'Mohamed El Idrissi', 'email' => 'mohamed.elidrissi@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 5, 'name' => 'Lisa van Dijk', 'email' => 'lisa.vandijk@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 6, 'name' => 'Youssef Benali', 'email' => 'youssef.benali@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 7, 'name' => 'Noor Bakker', 'email' => 'noor.bakker@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 8, 'name' => 'Kevin Smit', 'email' => 'kevin.smit@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 9, 'name' => 'Aylin Demir', 'email' => 'aylin.demir@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 10, 'name' => 'Tom Verhoeven', 'email' => 'tom.verhoeven@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 11, 'name' => 'Romy Jacobs', 'email' => 'romy.jacobs@kniplokettiko.nl', 'rolename' => 'medewerker'],
            ['id' => 12, 'name' => 'Piet van Loenen', 'email' => 'piet.van.loenen@gmail.com', 'rolename' => 'klant'],
            ['id' => 13, 'name' => 'Jan Jansen', 'email' => 'jan.jansen@outlook.com', 'rolename' => 'klant'],
            ['id' => 14, 'name' => 'Saskia de Boer', 'email' => 'saskia.deboer@yahoo.com', 'rolename' => 'klant'],
            ['id' => 15, 'name' => 'Ahmed Mansouri', 'email' => 'ahmed.mansouri@icloud.com', 'rolename' => 'klant'],
            ['id' => 16, 'name' => 'Marieke van den Berg', 'email' => 'marieke.vandenberg@ziggo.nl', 'rolename' => 'klant'],
            ['id' => 17, 'name' => 'Daan Visser', 'email' => 'daan.visser@live.nl', 'rolename' => 'klant'],
        ];

        $password = Hash::make('password');
        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $password,
                    'rolename' => $user['rolename'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        echo "✅ Database schema en testdata succesvol aangemaakt!\n";
        
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

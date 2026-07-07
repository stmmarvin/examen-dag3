<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        if (! Schema::hasTable('klant')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("
                    CREATE TABLE `klant` (
                      `Id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
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
                    )
                ");
            } else {
                Schema::create('klant', function (Blueprint $table) {
                    $table->id('Id');
                    $table->foreignId('UserId')->nullable()->constrained('users')->nullOnDelete();
                    $table->string('Voornaam');
                    $table->string('Tussenvoegsel', 50)->nullable();
                    $table->string('Achternaam');
                    $table->string('Relatienummer', 50)->nullable();
                    $table->text('Bijzonderheden')->nullable();
                    $table->boolean('IsActief')->default(true);
                    $table->string('Opmerking')->nullable();
                    $table->dateTime('DatumAangemaakt', 6)->nullable();
                    $table->dateTime('DatumGewijzigd', 6)->nullable();
                });
            }
        }

        if (! Schema::hasTable('Contact')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("
                    CREATE TABLE `Contact` (
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
                    )
                ");
            } else {
                Schema::create('Contact', function (Blueprint $table) {
                    $table->id('Id');
                    $table->string('Straatnaam')->nullable();
                    $table->string('Huisnummer', 10)->nullable();
                    $table->string('Toevoeging', 10)->nullable();
                    $table->string('Postcode', 10)->nullable();
                    $table->string('Plaats', 100)->nullable();
                    $table->string('Email')->nullable();
                    $table->string('Mobiel', 20)->nullable();
                    $table->boolean('IsActief')->default(true);
                    $table->string('Opmerking')->nullable();
                    $table->dateTime('DatumAangemaakt', 6)->nullable();
                    $table->dateTime('DatumGewijzigd', 6)->nullable();
                });
            }
        }

        if (! Schema::hasTable('KlantPerContact')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("
                    CREATE TABLE `KlantPerContact` (
                      `Id` INT PRIMARY KEY AUTO_INCREMENT,
                      `KlantId` BIGINT UNSIGNED NOT NULL,
                      `ContactId` INT NOT NULL,
                      `IsActief` BIT DEFAULT b'1',
                      `Opmerking` VARCHAR(255) NULL,
                      `DatumAangemaakt` DATETIME(6) NULL,
                      `DatumGewijzigd` DATETIME(6) NULL,
                      FOREIGN KEY (`KlantId`) REFERENCES `klant`(`Id`) ON DELETE CASCADE,
                      FOREIGN KEY (`ContactId`) REFERENCES `Contact`(`Id`) ON DELETE CASCADE
                    )
                ");
            } else {
                Schema::create('KlantPerContact', function (Blueprint $table) {
                    $table->id('Id');
                    $table->unsignedBigInteger('KlantId');
                    $table->unsignedBigInteger('ContactId');
                    $table->boolean('IsActief')->default(true);
                    $table->string('Opmerking')->nullable();
                    $table->dateTime('DatumAangemaakt', 6)->nullable();
                    $table->dateTime('DatumGewijzigd', 6)->nullable();
                });
            }
        }

        DB::table('users')->upsert([
            ['id' => 1, 'name' => 'Salon Eigenaar', 'email' => 'eigenaar@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'eigenaar', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 2, 'name' => 'Fatima El Amrani', 'email' => 'fatima@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 3, 'name' => 'Sanne de Vries', 'email' => 'sanne.devries@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 4, 'name' => 'Mohamed El Idrissi', 'email' => 'mohamed.elidrissi@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 5, 'name' => 'Lisa van Dijk', 'email' => 'lisa.vandijk@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 6, 'name' => 'Youssef Benali', 'email' => 'youssef.benali@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 7, 'name' => 'Noor Bakker', 'email' => 'noor.bakker@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 8, 'name' => 'Kevin Smit', 'email' => 'kevin.smit@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 9, 'name' => 'Aylin Demir', 'email' => 'aylin.demir@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 10, 'name' => 'Tom Verhoeven', 'email' => 'tom.verhoeven@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 11, 'name' => 'Romy Jacobs', 'email' => 'romy.jacobs@kniplokettiko.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'medewerker', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 12, 'name' => 'Piet van Loenen', 'email' => 'piet.van.loenen@gmail.com', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'klant', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 13, 'name' => 'Jan Jansen', 'email' => 'jan.jansen@outlook.com', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'klant', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 14, 'name' => 'Saskia de Boer', 'email' => 'saskia.deboer@yahoo.com', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'klant', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 15, 'name' => 'Ahmed Mansouri', 'email' => 'ahmed.mansouri@icloud.com', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'klant', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 16, 'name' => 'Marieke van den Berg', 'email' => 'marieke.vandenberg@ziggo.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'klant', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
            ['id' => 17, 'name' => 'Daan Visser', 'email' => 'daan.visser@live.nl', 'email_verified_at' => null, 'password' => '$2y$10$1S7dpZxfyl4IcQAtIzUklulMSor3EADTAPktFHNcFsg87geQVgrMu', 'rolename' => 'klant', 'remember_token' => null, 'created_at' => '2026-07-02 09:09:30', 'updated_at' => '2026-07-02 09:09:30'],
        ], ['id'], ['name', 'email', 'email_verified_at', 'password', 'rolename', 'remember_token', 'created_at', 'updated_at']);

        DB::table('klant')->upsert([
            ['Id' => 1, 'UserId' => 12, 'Voornaam' => 'Piet', 'Tussenvoegsel' => 'van', 'Achternaam' => 'Loenen', 'Relatienummer' => 'KL-2026-001', 'Bijzonderheden' => 'Voorkeur voor ochtendafspraken.', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 2, 'UserId' => 13, 'Voornaam' => 'Jan', 'Tussenvoegsel' => null, 'Achternaam' => 'Jansen', 'Relatienummer' => 'KL-2026-002', 'Bijzonderheden' => 'Allergie voor sterk geparfumeerde producten.', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 3, 'UserId' => 14, 'Voornaam' => 'Saskia', 'Tussenvoegsel' => 'de', 'Achternaam' => 'Boer', 'Relatienummer' => 'KL-2026-003', 'Bijzonderheden' => 'Komt elke zes weken.', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 4, 'UserId' => 15, 'Voornaam' => 'Ahmed', 'Tussenvoegsel' => null, 'Achternaam' => 'Mansouri', 'Relatienummer' => 'KL-2026-004', 'Bijzonderheden' => 'Wil strakke fade.', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 5, 'UserId' => 16, 'Voornaam' => 'Marieke', 'Tussenvoegsel' => 'van den', 'Achternaam' => 'Berg', 'Relatienummer' => 'KL-2026-005', 'Bijzonderheden' => 'Gevoelige hoofdhuid.', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 6, 'UserId' => 17, 'Voornaam' => 'Daan', 'Tussenvoegsel' => null, 'Achternaam' => 'Visser', 'Relatienummer' => 'KL-2026-006', 'Bijzonderheden' => 'Liefst einde middag.', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
        ], ['Id'], ['UserId', 'Voornaam', 'Tussenvoegsel', 'Achternaam', 'Relatienummer', 'Bijzonderheden', 'IsActief', 'Opmerking', 'DatumAangemaakt', 'DatumGewijzigd']);

        DB::table('Contact')->upsert([
            ['Id' => 1, 'Straatnaam' => 'Kanaalstraat', 'Huisnummer' => '12', 'Toevoeging' => null, 'Postcode' => '3511AB', 'Plaats' => 'Utrecht', 'Email' => 'fatima@kniplokettiko.nl', 'Mobiel' => '0612345678', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 2, 'Straatnaam' => 'Croeselaan', 'Huisnummer' => '101', 'Toevoeging' => null, 'Postcode' => '3521BJ', 'Plaats' => 'Utrecht', 'Email' => 'sanne.devries@kniplokettiko.nl', 'Mobiel' => '0611111111', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 3, 'Straatnaam' => 'Amsterdamsestraatweg', 'Huisnummer' => '223', 'Toevoeging' => null, 'Postcode' => '3551CG', 'Plaats' => 'Utrecht', 'Email' => 'mohamed.elidrissi@kniplokettiko.nl', 'Mobiel' => '0611111112', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 4, 'Straatnaam' => 'Maliebaan', 'Huisnummer' => '17', 'Toevoeging' => null, 'Postcode' => '3581CC', 'Plaats' => 'Utrecht', 'Email' => 'lisa.vandijk@kniplokettiko.nl', 'Mobiel' => '0611111113', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 5, 'Straatnaam' => 'Balijelaan', 'Huisnummer' => '63', 'Toevoeging' => null, 'Postcode' => '3521GM', 'Plaats' => 'Utrecht', 'Email' => 'youssef.benali@kniplokettiko.nl', 'Mobiel' => '0611111114', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 6, 'Straatnaam' => 'Nachtegaalstraat', 'Huisnummer' => '95', 'Toevoeging' => null, 'Postcode' => '3581AE', 'Plaats' => 'Utrecht', 'Email' => 'noor.bakker@kniplokettiko.nl', 'Mobiel' => '0611111115', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 7, 'Straatnaam' => 'Bernardlaan', 'Huisnummer' => '7', 'Toevoeging' => null, 'Postcode' => '3527GA', 'Plaats' => 'Utrecht', 'Email' => 'kevin.smit@kniplokettiko.nl', 'Mobiel' => '0611111116', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 8, 'Straatnaam' => 'Laan van Nieuw-Guinea', 'Huisnummer' => '141', 'Toevoeging' => null, 'Postcode' => '3531JE', 'Plaats' => 'Utrecht', 'Email' => 'aylin.demir@kniplokettiko.nl', 'Mobiel' => '0611111117', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 9, 'Straatnaam' => 'Marnixlaan', 'Huisnummer' => '205', 'Toevoeging' => null, 'Postcode' => '3552HD', 'Plaats' => 'Utrecht', 'Email' => 'tom.verhoeven@kniplokettiko.nl', 'Mobiel' => '0611111118', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 10, 'Straatnaam' => 'Haroekoeplein', 'Huisnummer' => '29', 'Toevoeging' => null, 'Postcode' => '3531WK', 'Plaats' => 'Utrecht', 'Email' => 'romy.jacobs@kniplokettiko.nl', 'Mobiel' => '0611111119', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 11, 'Straatnaam' => 'Oudegracht', 'Huisnummer' => '88', 'Toevoeging' => 'A', 'Postcode' => '3512AB', 'Plaats' => 'Utrecht', 'Email' => 'piet.van.loenen@gmail.com', 'Mobiel' => '+31 6 1234 61 71', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 12, 'Straatnaam' => 'Biltstraat', 'Huisnummer' => '44', 'Toevoeging' => null, 'Postcode' => '3572BC', 'Plaats' => 'Utrecht', 'Email' => 'jan.jansen@outlook.com', 'Mobiel' => '+31 6 1234 61 72', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 13, 'Straatnaam' => 'Merelstraat', 'Huisnummer' => '12', 'Toevoeging' => null, 'Postcode' => '3514CN', 'Plaats' => 'Utrecht', 'Email' => 'saskia.deboer@yahoo.com', 'Mobiel' => '+31 6 1234 61 73', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 14, 'Straatnaam' => 'Winkel van Sinkelstraat', 'Huisnummer' => '4', 'Toevoeging' => null, 'Postcode' => '3511KV', 'Plaats' => 'Utrecht', 'Email' => 'ahmed.mansouri@icloud.com', 'Mobiel' => '+31 6 1234 61 74', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 15, 'Straatnaam' => 'Adelaarstraat', 'Huisnummer' => '50', 'Toevoeging' => null, 'Postcode' => '3514CH', 'Plaats' => 'Utrecht', 'Email' => 'marieke.vandenberg@ziggo.nl', 'Mobiel' => '+31 6 1234 61 75', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 16, 'Straatnaam' => 'Vleutenseweg', 'Huisnummer' => '73', 'Toevoeging' => null, 'Postcode' => '3532HA', 'Plaats' => 'Utrecht', 'Email' => 'daan.visser@live.nl', 'Mobiel' => '+31 6 1234 61 76', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
        ], ['Id'], ['Straatnaam', 'Huisnummer', 'Toevoeging', 'Postcode', 'Plaats', 'Email', 'Mobiel', 'IsActief', 'Opmerking', 'DatumAangemaakt', 'DatumGewijzigd']);

        DB::table('KlantPerContact')->upsert([
            ['Id' => 1, 'KlantId' => 1, 'ContactId' => 11, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 2, 'KlantId' => 2, 'ContactId' => 12, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 3, 'KlantId' => 3, 'ContactId' => 13, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 4, 'KlantId' => 4, 'ContactId' => 14, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 5, 'KlantId' => 5, 'ContactId' => 15, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
            ['Id' => 6, 'KlantId' => 6, 'ContactId' => 16, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => '2026-07-02 09:09:30.000000', 'DatumGewijzigd' => '2026-07-02 09:09:30.000000'],
        ], ['Id'], ['KlantId', 'ContactId', 'IsActief', 'Opmerking', 'DatumAangemaakt', 'DatumGewijzigd']);

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }

        Schema::dropIfExists('KlantPerContact');
        Schema::dropIfExists('Contact');
        Schema::dropIfExists('klant');

        if (DB::getDriverName() === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
};

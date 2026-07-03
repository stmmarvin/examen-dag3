<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductenSeeder extends Seeder
{
    public function run(): void
    {
        // Maak categorieen tabel als die niet bestaat
        DB::statement("
            CREATE TABLE IF NOT EXISTS `categorieen` (
              `id` INT PRIMARY KEY AUTO_INCREMENT,
              `naam` VARCHAR(255) NOT NULL,
              `omschrijving` TEXT NULL,
              `created_at` TIMESTAMP NULL,
              `updated_at` TIMESTAMP NULL
            )
        ");

        // Maak voorraad tabel als die niet bestaat  
        DB::statement("
            CREATE TABLE IF NOT EXISTS `voorraad` (
              `id` INT PRIMARY KEY AUTO_INCREMENT,
              `product_id` BIGINT UNSIGNED NOT NULL,
              `aantal_op_voorraad` INT NOT NULL DEFAULT 0,
              `aantal_uitgegeven` INT NOT NULL DEFAULT 0,
              `aantal_bijgekomen` INT NOT NULL DEFAULT 0,
              `created_at` TIMESTAMP NULL,
              `updated_at` TIMESTAMP NULL
            )
        ");

        // Insert Categorieën
        $categorieen = [
            ['id' => 1, 'naam' => 'Haarverzorging', 'omschrijving' => 'Producten voor wassen en verzorgen'],
            ['id' => 2, 'naam' => 'Kleurproducten', 'omschrijving' => 'Producten voor kleurbehandelingen'],
            ['id' => 3, 'naam' => 'Styling', 'omschrijving' => 'Producten voor afwerking en styling'],
            ['id' => 4, 'naam' => 'Accessoires', 'omschrijving' => 'Accessoires voor verkoop in de salon'],
        ];

        foreach ($categorieen as $cat) {
            DB::table('categorieen')->insert($cat);
        }

        // Insert Producten
        $producten = [
            ['id' => 1, 'categorie_id' => 1, 'naam' => 'Hydrating Shampoo', 'omschrijving' => 'Milde salonshampoo voor dagelijks gebruik', 'merk' => 'Tiko Care', 'ean_code' => '0871234500001', 'houdbaarheidsdatum' => '2027-07-01', 'inkoop_prijs' => 6.50, 'verkoop_prijs' => 14.95],
            ['id' => 2, 'categorie_id' => 1, 'naam' => 'Repair Conditioner', 'omschrijving' => 'Voedende conditioner voor beschadigd haar', 'merk' => 'Tiko Care', 'ean_code' => '0871234500002', 'houdbaarheidsdatum' => '2027-10-15', 'inkoop_prijs' => 7.25, 'verkoop_prijs' => 16.95],
            ['id' => 3, 'categorie_id' => 1, 'naam' => 'Scalp Balance Masker', 'omschrijving' => 'Kalmerend haarmasker voor gevoelige hoofdhuid', 'merk' => 'Tiko Care', 'ean_code' => '0871234500003', 'houdbaarheidsdatum' => '2027-05-20', 'inkoop_prijs' => 8.75, 'verkoop_prijs' => 19.95],
            ['id' => 4, 'categorie_id' => 1, 'naam' => 'Baardolie Cedar', 'omschrijving' => 'Verzorgende olie voor baardbehandelingen', 'merk' => 'Tiko Beard', 'ean_code' => '0871234500004', 'houdbaarheidsdatum' => '2027-09-30', 'inkoop_prijs' => 5.75, 'verkoop_prijs' => 12.95],
            ['id' => 5, 'categorie_id' => 2, 'naam' => 'Color Creme 6.1', 'omschrijving' => 'Professionele asdonkerblonde kleurcreme', 'merk' => 'Tiko Color', 'ean_code' => '0871234500005', 'houdbaarheidsdatum' => '2026-12-31', 'inkoop_prijs' => 12.50, 'verkoop_prijs' => 24.95],
            ['id' => 6, 'categorie_id' => 2, 'naam' => 'Color Creme 7.43', 'omschrijving' => 'Koperblonde salonkleur met warme ondertoon', 'merk' => 'Tiko Color', 'ean_code' => '0871234500006', 'houdbaarheidsdatum' => '2027-01-31', 'inkoop_prijs' => 12.75, 'verkoop_prijs' => 25.95],
            ['id' => 7, 'categorie_id' => 2, 'naam' => 'Developer 6 Procent', 'omschrijving' => 'Oxidatiecreme voor kleurbehandelingen', 'merk' => 'Tiko Color', 'ean_code' => '0871234500007', 'houdbaarheidsdatum' => '2027-03-31', 'inkoop_prijs' => 5.95, 'verkoop_prijs' => 11.95],
            ['id' => 8, 'categorie_id' => 3, 'naam' => 'Matte Styling Clay', 'omschrijving' => 'Matte clay met flexibele hold', 'merk' => 'Tiko Style', 'ean_code' => '0871234500008', 'houdbaarheidsdatum' => '2027-08-31', 'inkoop_prijs' => 4.95, 'verkoop_prijs' => 12.95],
            ['id' => 9, 'categorie_id' => 3, 'naam' => 'Strong Hold Gel', 'omschrijving' => 'Sterke hold styling gel', 'merk' => 'Tiko Style', 'ean_code' => '0871234500009', 'houdbaarheidsdatum' => '2027-03-31', 'inkoop_prijs' => 4.25, 'verkoop_prijs' => 9.95],
            ['id' => 10, 'categorie_id' => 3, 'naam' => 'Heat Protect Spray', 'omschrijving' => 'Beschermende spray voor föhnen en stylen', 'merk' => 'Tiko Style', 'ean_code' => '0871234500010', 'houdbaarheidsdatum' => '2027-11-30', 'inkoop_prijs' => 6.10, 'verkoop_prijs' => 15.95],
        ];

        foreach ($producten as $product) {
            DB::table('producten')->insert($product);
        }

        // Insert Voorraad
        $voorraad = [
            ['product_id' => 1, 'aantal_op_voorraad' => 40, 'aantal_uitgegeven' => 0, 'aantal_bijgekomen' => 40],
            ['product_id' => 2, 'aantal_op_voorraad' => 28, 'aantal_uitgegeven' => 2, 'aantal_bijgekomen' => 30],
            ['product_id' => 3, 'aantal_op_voorraad' => 18, 'aantal_uitgegeven' => 0, 'aantal_bijgekomen' => 18],
            ['product_id' => 4, 'aantal_op_voorraad' => 20, 'aantal_uitgegeven' => 0, 'aantal_bijgekomen' => 20],
            ['product_id' => 5, 'aantal_op_voorraad' => 25, 'aantal_uitgegeven' => 0, 'aantal_bijgekomen' => 25],
            ['product_id' => 6, 'aantal_op_voorraad' => 16, 'aantal_uitgegeven' => 1, 'aantal_bijgekomen' => 17],
            ['product_id' => 7, 'aantal_op_voorraad' => 32, 'aantal_uitgegeven' => 3, 'aantal_bijgekomen' => 35],
            ['product_id' => 8, 'aantal_op_voorraad' => 22, 'aantal_uitgegeven' => 0, 'aantal_bijgekomen' => 22],
            ['product_id' => 9, 'aantal_op_voorraad' => 35, 'aantal_uitgegeven' => 0, 'aantal_bijgekomen' => 35],
            ['product_id' => 10, 'aantal_op_voorraad' => 24, 'aantal_uitgegeven' => 1, 'aantal_bijgekomen' => 25],
        ];

        foreach ($voorraad as $v) {
            DB::table('voorraad')->insert($v);
        }

        echo "✅ 4 Categorieën toegevoegd\n";
        echo "✅ 10 Producten toegevoegd\n";
        echo "✅ Voorraad informatie toegevoegd\n";
    }
}

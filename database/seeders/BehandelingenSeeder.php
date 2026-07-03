<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BehandelingenSeeder extends Seeder
{
    public function run(): void
    {
        // Create behandelingen
        $behandelingen = [
            [
                'naam' => 'Combi behandelingen',
                'beschrijving' => 'Combinatie van knippen, kleuren en stylen.',
                'duur' => 90,
                'prijs' => 90.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Extensions',
                'beschrijving' => 'Plaatsen en verzorgen van extensions.',
                'duur' => 180,
                'prijs' => 250.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Kleuren',
                'beschrijving' => 'Haar kleuren (diverse technieken).',
                'duur' => 60,
                'prijs' => 60.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Knippen',
                'beschrijving' => 'Haar knippen en eventueel stylen.',
                'duur' => 30,
                'prijs' => 30.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($behandelingen as $behandeling) {
            DB::table('behandelingen')->insert($behandeling);
        }

        // Create producten
        $producten = [
            [
                'naam' => 'Hydrating Shampoo',
                'beschrijving' => 'Milde salonshampoo voor dagelijks gebruik.',
                'prijs' => 14.95,
                'voorraad' => 40,
                'sku' => '0871234500001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Repair Conditioner',
                'beschrijving' => 'Voedende conditioner voor beschadigd haar.',
                'prijs' => 16.95,
                'voorraad' => 28,
                'sku' => '0871234500002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'naam' => 'Scalp Balance Masker',
                'beschrijving' => 'Kalmerend haarmasker voor gevoelige hoofdhuid.',
                'prijs' => 19.95,
                'voorraad' => 18,
                'sku' => '0871234500003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($producten as $product) {
            DB::table('producten')->insert($product);
        }

        // Link producten to behandelingen (pivot table)
        DB::table('behandeling_product')->insert([
            // Combi behandelingen uses 3 products
            ['behandeling_id' => 1, 'product_id' => 1, 'aantal' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['behandeling_id' => 1, 'product_id' => 2, 'aantal' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['behandeling_id' => 1, 'product_id' => 3, 'aantal' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Extensions uses 1 product
            ['behandeling_id' => 2, 'product_id' => 2, 'aantal' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Kleuren uses 1 product
            ['behandeling_id' => 3, 'product_id' => 1, 'aantal' => 1, 'created_at' => now(), 'updated_at' => now()],
            
            // Knippen uses 2 products
            ['behandeling_id' => 4, 'product_id' => 1, 'aantal' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['behandeling_id' => 4, 'product_id' => 3, 'aantal' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

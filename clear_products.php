<?php
// Script om producten te legen voordat je de SQL file uitvoert

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🗑️  Producten en categorieën aan het verwijderen...\n";

DB::statement('SET FOREIGN_KEY_CHECKS = 0');
DB::table('Voorraad')->truncate();
DB::table('Product')->truncate();
DB::table('Categorie')->truncate();
DB::statement('SET FOREIGN_KEY_CHECKS = 1');

echo "✅ Producten, categorieën en voorraad succesvol verwijderd!\n";
echo "✅ Voer nu de SQL file uit in MySQL Workbench of via command line\n";

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('producten', function (Blueprint $table) {
            // Verwijder oude kolommen
            $table->dropColumn(['beschrijving', 'prijs', 'voorraad', 'sku']);
            
            // Voeg nieuwe kolommen toe
            $table->unsignedBigInteger('categorie_id')->nullable()->after('id');
            $table->text('omschrijving')->nullable()->after('naam');
            $table->string('merk')->nullable()->after('omschrijving');
            $table->string('ean_code')->nullable()->after('merk');
            $table->date('houdbaarheidsdatum')->nullable()->after('ean_code');
            $table->decimal('inkoop_prijs', 10, 2)->nullable()->after('houdbaarheidsdatum');
            $table->decimal('verkoop_prijs', 10, 2)->nullable()->after('inkoop_prijs');
        });
    }

    public function down(): void
    {
        Schema::table('producten', function (Blueprint $table) {
            $table->dropColumn(['categorie_id', 'omschrijving', 'merk', 'ean_code', 'houdbaarheidsdatum', 'inkoop_prijs', 'verkoop_prijs']);
            $table->text('beschrijving')->nullable();
            $table->decimal('prijs', 8, 2);
            $table->integer('voorraad')->default(0);
            $table->string('sku')->unique();
        });
    }
};

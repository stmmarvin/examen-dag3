<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('producten')) {
            return;
        }

        Schema::table('producten', function (Blueprint $table) {
            $oudeKolommen = array_filter(
                ['beschrijving', 'prijs', 'voorraad', 'sku'],
                fn ($kolom) => Schema::hasColumn('producten', $kolom)
            );

            if ($oudeKolommen) {
                $table->dropColumn($oudeKolommen);
            }

            if (! Schema::hasColumn('producten', 'categorie_id')) {
                $table->unsignedBigInteger('categorie_id')->nullable()->after('id');
            }

            if (! Schema::hasColumn('producten', 'omschrijving')) {
                $table->text('omschrijving')->nullable()->after('naam');
            }

            if (! Schema::hasColumn('producten', 'merk')) {
                $table->string('merk')->nullable()->after('omschrijving');
            }

            if (! Schema::hasColumn('producten', 'ean_code')) {
                $table->string('ean_code')->nullable()->after('merk');
            }

            if (! Schema::hasColumn('producten', 'houdbaarheidsdatum')) {
                $table->date('houdbaarheidsdatum')->nullable()->after('ean_code');
            }

            if (! Schema::hasColumn('producten', 'inkoop_prijs')) {
                $table->decimal('inkoop_prijs', 10, 2)->nullable()->after('houdbaarheidsdatum');
            }

            if (! Schema::hasColumn('producten', 'verkoop_prijs')) {
                $table->decimal('verkoop_prijs', 10, 2)->nullable()->after('inkoop_prijs');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('producten')) {
            return;
        }

        Schema::table('producten', function (Blueprint $table) {
            $nieuweKolommen = array_filter(
                ['categorie_id', 'omschrijving', 'merk', 'ean_code', 'houdbaarheidsdatum', 'inkoop_prijs', 'verkoop_prijs'],
                fn ($kolom) => Schema::hasColumn('producten', $kolom)
            );

            if ($nieuweKolommen) {
                $table->dropColumn($nieuweKolommen);
            }

            if (! Schema::hasColumn('producten', 'beschrijving')) {
                $table->text('beschrijving')->nullable();
            }

            if (! Schema::hasColumn('producten', 'prijs')) {
                $table->decimal('prijs', 8, 2);
            }

            if (! Schema::hasColumn('producten', 'voorraad')) {
                $table->integer('voorraad')->default(0);
            }

            if (! Schema::hasColumn('producten', 'sku')) {
                $table->string('sku')->unique();
            }
        });
    }
};

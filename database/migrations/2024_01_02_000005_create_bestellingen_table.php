<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bestellingen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klant_id')->constrained('klanten')->onDelete('cascade');
            $table->dateTime('besteldatum');
            $table->enum('status', ['in_behandeling', 'verzonden', 'afgeleverd', 'geannuleerd'])->default('in_behandeling');
            $table->decimal('totaal_bedrag', 10, 2);
            $table->timestamps();
        });

        Schema::create('bestelling_regels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bestelling_id')->constrained('bestellingen')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('producten')->onDelete('cascade');
            $table->integer('aantal');
            $table->decimal('prijs', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bestelling_regels');
        Schema::dropIfExists('bestellingen');
    }
};

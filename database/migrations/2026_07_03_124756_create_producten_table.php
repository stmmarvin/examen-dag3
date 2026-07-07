<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producten', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->string('naam');
            $table->text('omschrijving')->nullable();
            $table->string('merk')->nullable();
            $table->string('ean_code')->nullable();
            $table->date('houdbaarheidsdatum')->nullable();
            $table->decimal('inkoop_prijs', 10, 2)->nullable();
            $table->decimal('verkoop_prijs', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producten');
    }
};

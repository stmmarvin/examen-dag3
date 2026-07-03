<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('afspraken', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klant_id')->constrained('klanten')->onDelete('cascade');
            $table->foreignId('behandeling_id')->constrained('behandelingen')->onDelete('cascade');
            $table->dateTime('datum_tijd');
            $table->enum('status', ['gepland', 'bevestigd', 'voltooid', 'geannuleerd'])->default('gepland');
            $table->text('notities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('afspraken');
    }
};

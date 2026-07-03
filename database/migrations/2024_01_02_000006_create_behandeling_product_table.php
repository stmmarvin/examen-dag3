<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('behandeling_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('behandeling_id')->constrained('behandelingen')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('producten')->onDelete('cascade');
            $table->integer('aantal')->default(1); // Number of products needed for the treatment
            $table->timestamps();

            $table->unique(['behandeling_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('behandeling_product');
    }
};

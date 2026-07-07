<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('medewerker_per_contact')) {
            Schema::create('medewerker_per_contact', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('medewerker_id');
                $table->unsignedInteger('contact_id');
                $table->boolean('is_actief')->default(true);
                $table->string('opmerking')->nullable();
                $table->dateTime('datum_aangemaakt', 6)->nullable();
                $table->dateTime('datum_gewijzigd', 6)->nullable();

                $table->index('medewerker_id');
                $table->index('contact_id');
            });
        }

        if (
            Schema::hasTable('medewerker_per_contact')
            && Schema::hasTable('medewerker')
            && Schema::hasTable('Contact')
            && DB::table('medewerker_per_contact')->count() === 0
        ) {
            $koppelingen = collect(range(1, 10))->map(fn (int $id) => [
                'medewerker_id' => $id,
                'contact_id' => $id,
                'is_actief' => true,
                'opmerking' => null,
                'datum_aangemaakt' => now(),
                'datum_gewijzigd' => now(),
            ])->all();

            DB::table('medewerker_per_contact')->insert($koppelingen);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('medewerker_per_contact');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
           Schema::create('profesor_predmet', function (Blueprint $table) {
            $table->id();

            // FK ka vrsta_korisnika (profesor)
            $table->foreignId('vrsta_korisnika_id')
                  ->constrained('vrsta_korisnika')
                  ->onDelete('cascade');

            // FK ka predmetu
            $table->foreignId('predmet_id')
                  ->constrained('predmet')
                  ->onDelete('cascade');

            $table->timestamps();

            // Unikatni indeks da profesor ne može imati isti predmet više puta
            $table->unique(['vrsta_korisnika_id', 'predmet_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor_predmet');
    }
};

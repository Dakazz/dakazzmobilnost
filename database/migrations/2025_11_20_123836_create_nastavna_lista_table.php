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
         Schema::create('nastavne_liste', function (Blueprint $table) {
            $table->id();

            // Veza na predmet (strani predmet)
            $table->foreignId('predmet_id')
                  ->constrained('predmet')
                  ->onDelete('cascade');

            // Naziv fajla (npr. "Nastavna lista 2025")
            $table->string('naziv');

            // Putanja do fajla u storage-u
            $table->string('path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nastavna_lista');
    }
};

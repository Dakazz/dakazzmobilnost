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
        Schema::create('learning_agreement', function (Blueprint $table) {
            $table->id();
            $table->date('datum_pocetka');
            $table->text('napomena')->nullable();

            // samo upload original LA (dodajemo polje za dokument)
            $table->string('dokument_path')->nullable();

            $table->foreignId('mobilnost_id')
                  ->constrained('mobilnost')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_agreement');
    }
};

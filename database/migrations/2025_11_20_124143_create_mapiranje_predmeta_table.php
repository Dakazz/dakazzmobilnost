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
       Schema::create('mapiranje_predmeta', function (Blueprint $table) {
            $table->id();

            $table->date('datum')->nullable();
            $table->enum('status', ['u procesu', 'odobren', 'odbijen'])->default('u procesu');
            $table->text('napomena')->nullable();
            $table->string('ocjena')->nullable();

            // FK veze
            $table->foreignId('mobilnost_id')
                  ->constrained('mobilnost')
                  ->onDelete('cascade');

            $table->foreignId('prepis_id')
                  ->constrained('prepis')
                  ->onDelete('cascade');

            $table->foreignId('predmet_id')
                  ->constrained('predmet')
                  ->onDelete('restrict');

            $table->foreignId('vrsta_korisnika_id')
                  ->constrained('vrsta_korisnika')
                  ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapiranje_predmeta');
    }
};

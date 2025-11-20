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
        Schema::create('student_predmet', function (Blueprint $table) {
    $table->id();

    $table->foreignId('student_id')
          ->constrained('student')
          ->onDelete('cascade');

    $table->foreignId('predmet_id')
          ->constrained('predmet')
          ->onDelete('cascade');

    $table->timestamps();

    $table->unique(['student_id', 'predmet_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_predmet');
    }
};

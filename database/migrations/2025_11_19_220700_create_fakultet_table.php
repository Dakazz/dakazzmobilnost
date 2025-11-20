<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fakultet', function (Blueprint $table) {
            $table->id();
            $table->string('naziv')->unique();
            $table->string('email')->unique();
            $table->string('telefon');
            $table->string('web')->nullable();
            $table->text('uputstvo_za_ocjene')->nullable();
            $table->foreignId('univerzitet_id')
                  ->constrained('univerzitet')
                  ->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fakultet');
    }
};

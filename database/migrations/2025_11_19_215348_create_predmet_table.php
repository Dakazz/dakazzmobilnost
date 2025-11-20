<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predmet', function (Blueprint $table) {
            $table->id();
            $table->string('naziv')->unique();
            $table->integer('ects');
            $table->integer('semestar');
            $table->string('naziv_teze')->nullable();
            $table->date('datum_teze')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predmet');
    }
};

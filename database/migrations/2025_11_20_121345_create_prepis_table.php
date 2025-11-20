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
      Schema::create('prepis', function (Blueprint $table) {
            $table->id();
            $table->date('datum');
            
            // ENUM status: ‘u procesu’, ‘odobren’, ‘odbijen’
            $table->enum('status', ['u procesu', 'odobren', 'odbijen'])->default('u procesu');

            $table->text('napomena')->nullable();

            $table->foreignId('fakultet_id')
                  ->constrained('fakultet')
                  ->onDelete('restrict');

            $table->foreignId('student_id')
                  ->constrained('student')
                  ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prepis');
    }
};

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
        Schema::table('learning_agreements', function (Blueprint $table) {
            $table->string('broj_indeksa')->unique()->after('naziv_fakulteta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_agreements', function (Blueprint $table) {
            //
        });
    }
};

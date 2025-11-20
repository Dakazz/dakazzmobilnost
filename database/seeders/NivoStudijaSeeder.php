<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <- OBAVEZNO

class NivoStudijaSeeder extends Seeder
{
    public function run(): void
    {
        $nivo_studija = ['Osnovne', 'Master', 'Doktorski'];

        foreach ($nivo_studija as $nivo) {
            DB::table('nivo_studija')->updateOrInsert(
                ['naziv' => $nivo],
                ['naziv' => $nivo]
            );
        }
    }
}

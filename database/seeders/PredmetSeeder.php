<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PredmetSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('predmet')->truncate();

        $predmeti = [
            [
                'naziv' => 'Matematika',
                'ects' => 6,
                'semestar' => 1,
                'naziv_teze' => 'Analiza funkcija',
                'datum_teze' => '2025-12-01',
            ],
            [
                'naziv' => 'Fizika',
                'ects' => 5,
                'semestar' => 1,
                'naziv_teze' => null,
                'datum_teze' => null,
            ],
            [
                'naziv' => 'Programiranje',
                'ects' => 6,
                'semestar' => 2,
                'naziv_teze' => 'Algoritmi i strukture podataka',
                'datum_teze' => '2025-12-10',
            ],
        ];

        foreach ($predmeti as $predmet) {
            DB::table('predmet')->updateOrInsert(
                ['naziv' => $predmet['naziv']],
                $predmet
            );
        }
    }
}

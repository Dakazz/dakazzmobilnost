<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'br_indexa' => '12/24',
                'ime' => 'Marko',
                'prezime' => 'Marković',
                'datum_rodjenja' => '2000-05-10',
                'telefon' => '067234587',
                'email' => 'marko@example.com',
                'godina_studija' => 3,
                'br_pasosa' => null,
                'nivo_studija_id' => 1, // Osnovne
            ],
            [
                'br_indexa' => '23/25',
                'ime' => 'Ana',
                'prezime' => 'Anić',
                'datum_rodjenja' => '1999-11-15',
                'telefon' => '069987654',
                'email' => 'ana@example.com',
                'godina_studija' => 2,
                'br_pasosa' => null,
                'nivo_studija_id' => 1, // Osnovne
            ],
        ];

        foreach ($students as $student) {
            DB::table('student')->updateOrInsert(
                ['br_indexa' => $student['br_indexa']],
                $student
            );
        }
    }
}

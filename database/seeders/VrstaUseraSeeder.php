namespace Database\Seeders;
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VrstaUseraSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vrsta_usera')->insert([
            ['naziv' => 'admin'],
            ['naziv' => 'profesor'],
            ['naziv' => 'koordinator'],
        ]);
    }
}

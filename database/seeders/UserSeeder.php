<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $adminObj = new User();
        $adminObj->name = 'Admin';
        $adminObj->email = 'admin@gmail.com';
        $adminObj->password = Hash::make('12345');
        $adminObj->type = 0;
        $adminObj->save();

        $profesorObj = new User();
        $profesorObj->name = 'Profesor';
        $profesorObj->email = 'profesor@gmail.com';
        $profesorObj->password = Hash::make('12345');
        $profesorObj->type = 1;
        $profesorObj->save();
    }
}

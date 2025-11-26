<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;                 // ovo je potrebno
use Illuminate\Support\Facades\Hash;


class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('tajna123'),
            'is_admin' => true,
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['telephone' => 70000000],
            [
                'name'      => 'Juan',
                'prenom'    => 'Prince',
                'telephone' => 67501316,
                'email'     => 'prince@gmail.com',
                'password'  => Hash::make('princeboss'),
                'role'      => 'admin',
                'isActif'   => true,
            ]
        );

        User::firstOrCreate(
            ['telephone' => 70000000],
            [
                'name'      => 'bara',
                'prenom'    => 'saki',
                'telephone' => 60000000,
                'email'     => 'saki@gmail.com',
                'password'  => Hash::make('princeboss'),
                'role'      => 'user',
                'isActif'   => true,
            ]
        );
    }
}

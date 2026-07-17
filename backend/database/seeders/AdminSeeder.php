<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate( //create a new record if it not existing otherwise update the record.
             ['email' => 'admin@talenthub.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status' => 'active',
            ]);

            User::updateOrCreate(
            ['email' => 'employer@test.com'],
            [
                'name' => 'Employer User',
                'password' => Hash::make('password123'),
                'role' => 'employer',
                'status' => 'active',
        ]);

        User::updateOrCreate(
        ['email' => 'candidate@test.com'],
        [
            'name' => 'Candidate User',
            'password' => Hash::make('password123'),
            'role' => 'candidate',
            'status' => 'active',
        ]);
    }
}

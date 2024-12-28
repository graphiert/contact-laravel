<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Contact::factory(40)->create();
        User::create([
            'name' => 'Galih',
            'email' => 'galihpujiirianto@gmail.com',
            'password' => Hash::make('rowosari')
        ]);
    }
}

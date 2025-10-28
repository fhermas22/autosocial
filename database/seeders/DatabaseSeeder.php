<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Administrator User (Admin)
        User::factory()->create([
            'name' => 'Admin AutoSocial',
            'email' => 'admin@autosocial.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
        ]);

        // 2. Standard Human User (Organic)
        User::factory()->create([
            'name' => 'Human User',
            'email' => 'human@autosocial.com',
            'password' => Hash::make('password'),
            'role' => 'HUMAN',
        ]);

        // 3. AI User (Automated)
        User::factory()->create([
            'name' => 'AI Bot Alpha',
            'email' => 'ai_alpha@autosocial.com',
            'password' => Hash::make(Str::random(10)), // Random password, not used for login
            'role' => 'AI',
        ]);

        // Creating some additional dummy users
        User::factory(5)->create();
    }
}

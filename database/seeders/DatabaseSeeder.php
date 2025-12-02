<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Admin User
        \App\Models\User::updateOrCreate(
            ['email' => 'dendi@example.com'],
            [
                'name' => 'dendi',
                'password' => bcrypt('dendi123'),
            ]
        );

        $this->call([
            SettingsSeeder::class,
            SensorSeeder::class,
        ]);
    }
}

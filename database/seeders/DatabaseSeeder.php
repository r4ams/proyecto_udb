<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@udb.com',
            'password' => bcrypt('admin$123')
        ]);

        $this->call([
            UserSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,
        ]);

    }
}

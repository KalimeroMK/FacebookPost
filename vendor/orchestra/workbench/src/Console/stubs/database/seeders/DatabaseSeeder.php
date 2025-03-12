<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Orchestra\Testbench\Factories\UserFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // UserFactory::new()->times(10)->create();

        UserFactory::new()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}

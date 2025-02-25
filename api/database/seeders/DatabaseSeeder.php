<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;
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

        // Admin::factory(5)->create();
        Admin::factory()->create([
            'name' => fake()->name(),
            'email' => 'test@example.com',
            'idNo' => 00000000,
            'staffNo' => 'CU000',
            'password' => static::$password ??= Hash::make('00000000'),
        ]);
    }
}

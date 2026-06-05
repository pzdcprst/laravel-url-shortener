<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'alice@example.com'],
            ['name' => 'Alice', 'password' => 'password'],
        );

        User::query()->updateOrCreate(
            ['email' => 'bob@example.com'],
            ['name' => 'Bob', 'password' => 'password'],
        );
    }
}

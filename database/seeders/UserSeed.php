<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'administrador',
            'email' => 'admin@email.com',
            'hero_id' => 1,
            'role' => Role::Admin,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        ]);

        User::create([
            'username' => 'arqueiro',
            'email' => 'arqueiro@email.com',
            'hero_id' => 14,
            'role' => Role::User,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        ]);
    }
}

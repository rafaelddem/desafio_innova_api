<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'character' => 'Aquele Acima de Todos',
            'role' => Role::Admin,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        ]);

        User::create([
            'username' => 'arqueiro',
            'email' => 'arqueiro@email.com',
            'character' => 'Arqueiro Verde',
            'role' => Role::User,
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
        ]);
    }
}

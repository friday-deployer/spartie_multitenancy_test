<?php

namespace Database\Seeders\Tenants;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tenant\User::create([
            'name' => "firstAdmin",
            'password' => Hash::make('11111111'),
            'email' => "testuser@example.com"

        ]);
    }
}

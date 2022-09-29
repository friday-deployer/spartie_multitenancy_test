<?php

namespace Database\Seeders;

use Database\Seeders\Tenants\UserSeeder;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Add only tenant/ seeders only
     *
     * @return void
     */
    public function run()
    { 
       $this->call([
        UserSeeder::class,
       ]);
    }
}

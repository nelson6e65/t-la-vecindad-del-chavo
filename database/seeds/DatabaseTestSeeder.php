<?php

use Illuminate\Database\Seeder;

class DatabaseTestSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTestSeeder::class);
        // $this->call(RolesTestSeeder::class);
        $this->call(TenantsTestSeeder::class);
    }
}

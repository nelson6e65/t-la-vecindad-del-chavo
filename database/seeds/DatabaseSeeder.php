<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DefaultRolesSeeder::class);
        $this->call(DefaultUsersSeeder::class);
        $this->call(DefaultTitlesSeeder::class);

        if (App::environment(['local', 'testing'])) {
            $this->call(DatabaseTestSeeder::class);
        }
    }
}

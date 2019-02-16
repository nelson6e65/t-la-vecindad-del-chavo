<?php

use App\Entities\User;
use Illuminate\Database\Seeder;
use Faker\Factory;

/**
 * Usuarios de prueba
 */
class UsersTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $users = factory(User::class, $faker->numberBetween(2, 5))->create();

        foreach ($users as $user) {
            $user->assignRole('admin');
        }
    }
}

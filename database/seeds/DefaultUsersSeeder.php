<?php

use App\Entities\User;

use Illuminate\Database\Seeder;

/**
 *
 */
class DefaultUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Administrador principal
        $name     = config('default.user.name');
        $email    = config('default.user.email');
        $password = config('default.user.password');

        $user = User::updateOrCreate(compact('email'), compact('name', 'password'));

        $user->assignRole('admin');
    }
}

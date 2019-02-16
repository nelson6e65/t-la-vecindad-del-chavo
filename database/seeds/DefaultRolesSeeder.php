<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

/**
 *
 */
class DefaultRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            'admin',
        ];

        foreach ($roles as $name) {
            // code...
            Role::updateOrCreate(compact('name'));
        }
    }
}

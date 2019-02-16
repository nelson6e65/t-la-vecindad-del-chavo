<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Usuarios de prueba
 */
class RolesTestSeeder extends Seeder
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
            'test',
            'test-superman',
            'test-role',
        ];

        foreach ($roles as $name) {
            Role::updateOrCreate(compact('name'));
        }
    }
}

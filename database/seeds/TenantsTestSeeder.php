<?php

use App\Entities\Title;
use App\Entities\Tenant;
use Illuminate\Database\Seeder;
use Faker\Factory;

/**
 * Usuarios de prueba
 */
class TenantsTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doña = Title::where('long', 'Doña')->first();

        $tenants = [
            'Florinda Corcuera y Villalpando' => [
                'nicknames' => ['Florinda'],
                'title_id'  => $doña->id,
                'number'    => 14,
            ],
            'Federico Bardón de la Regueira' => [
                'nicknames' => ['Quiko', 'Kiko'],
                'title_id'  => null,
                'number'    => 14,
            ],
        ];

        foreach ($tenants as $name => $data) {
            $tenant = Tenant::updateOrCreate(compact('name'), $data);
        }
    }
}

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
        $don  = Title::where('long', 'Don')->first();
        $prof = Title::where('long', 'Profesor')->first();

        $tenants = [
            'desconocido' => [
                'nicknames' => ['El Chavo'],
                'title_id'  => null,
                'number'    => 8,
                'img'       => 'chavo.jpg',
            ],
            'Ramón Valdéz' => [
                'nicknames' => ['Rondamón'],
                'title_id'  => $don->id,
                'number'    => 72,
                'img'       => 'rondamon.jpg',
            ],
            'Espergencia' => [
                'nicknames' => ['La Chilindrina'],
                'title_id'  => null,
                'number'    => 72,
                'img'       => 'chilindrina.jpeg',
            ],
            'Florinda Corcuera y Villalpando' => [
                'nicknames' => ['Florinda'],
                'title_id'  => $doña->id,
                'number'    => 14,
                'img'       => 'florinda.jpg',
            ],
            'Federico Bardón de la Regueira' => [
                'nicknames' => ['Quiko', 'Kiko'],
                'title_id'  => null,
                'number'    => 14,
                'img'       => 'quico.png',
            ],
            'Inocencio Jirafales' => [
                'nicknames' => ['Maistro longaniza', 'Papi', 'Longaniza'],
                'title_id'  => $prof->id,
                'number'    => 0,
                'img'       => 'jirafales.png',
            ],
            'Clotilde' => [
                'nicknames' => ['Bruja del 71', 'Venerable anciana'],
                'title_id'  => $doña->id,
                'number'    => 71,
                'img'       => 'cleotilde.jpg',
            ],
        ];

        foreach ($tenants as $name => $data) {
            $img = $data['img'];

            unset($data['img']);
            $tenant = Tenant::updateOrCreate(compact('name'), $data);

            $tenant->addMedia(resource_path('images/'.$img))
                ->preservingOriginal()
                ->toMediaCollection();
        }
    }
}

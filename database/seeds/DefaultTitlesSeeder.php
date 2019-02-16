<?php

use App\Entities\Title;

use Illuminate\Database\Seeder;

/**
 *
 */
class DefaultTitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titles = [
            'D.'        => 'Don',
            'Dña.'      => 'Doña',
            'Dr.'       => 'Doctor',
            'Dra.'      => 'Doctora',
            'Prof.'     => 'Profesor',
            'Prof.ª'    => 'Profesora',
            'Sr.'       => 'Señor',
            'Sra.'      => 'Señora',
            'Srta.'     => 'Señorita',
        ];

        foreach ($titles as $short => $long) {
            Title::updateOrCreate(compact('short'), compact('long'));
        }
    }
}

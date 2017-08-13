<?php

use App\Snowcone\Entities\Sucursales;
use Illuminate\Database\Seeder;

class SucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sucursales::create([
            'nombre' => 'Master',
            'direccion' => '',
            'telefono' => ''
        ]);

        Sucursales::create([
            'nombre' => 'Shell',
            'direccion' => '',
            'telefono' => ''
        ]);

        Sucursales::create([
            'nombre' => 'Cuartel 5',
            'direccion' => '',
            'telefono' => ''
        ]);

        Sucursales::create([
            'nombre' => 'Croacia',
            'direccion' => '',
            'telefono' => ''
        ]);

        Sucursales::create([
            'nombre' => 'Gaspar Campos',
            'direccion' => '',
            'telefono' => ''
        ]);
    }
}

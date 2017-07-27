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
    }
}

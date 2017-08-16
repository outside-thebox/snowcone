<?php

use App\Snowcone\Entities\Proveedor;
use Illuminate\Database\Seeder;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::create([
            'descripcion' => 'FRI-CREM'
        ]);

        Proveedor::create([
            'descripcion' => 'MAC-CREM'
        ]);

        Proveedor::create([
            'descripcion' => 'AIR-CREAM'
        ]);

        Proveedor::create([
            'descripcion' => 'ELVIO'
        ]);

        Proveedor::create([
            'descripcion' => 'PABLO'
        ]);

        Proveedor::create([
            'descripcion' => 'MARPE'
        ]);

        Proveedor::create([
            'descripcion' => 'BON-MI'
        ]);

        Proveedor::create([
            'descripcion' => 'PERELLO'
        ]);

        Proveedor::create([
            'descripcion' => 'PATY'
        ]);

        Proveedor::create([
            'descripcion' => 'TANG'
        ]);

        Proveedor::create([
            'descripcion' => 'PANCHO'
        ]);

        Proveedor::create([
            'descripcion' => 'HELADOS-GABY'
        ]);

    }
}
